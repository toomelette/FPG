<?php

namespace App\Http\Controllers\Api\Records;

use App\Models\RECORDS\DMSAttachment;
use App\Swep\Helpers\__static;
use App\Http\Controllers\Controller;
use App\Models\RECORDS\DMSDocuments;
use App\Models\RECORDS\DMSFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DMSController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1. Receive document array
            $documentArray = json_decode($request->input('documentArray'), true) ?? [];

            // 2. Receive file array
            $fileArray = json_decode($request->input('fileArray'), true) ?? [];

            // 2. Receive file array
            $attachmentArray = json_decode($request->input('attachmentArray'), true) ?? [];

            Log::info('Data received', [
                'documents' => count($documentArray),
                'files_metadata' => count($fileArray),
                'attachment_metadata' => count($attachmentArray)
            ]);

            // 3. Process uploaded files
            $uploadedFiles = $request->file('files', []);
            $uploadedFiles = is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles];

            $savedFiles = [];
            foreach ($uploadedFiles as $uploadedFile) {
                if ($uploadedFile && $uploadedFile->isValid()) {
                    $filename = $uploadedFile->getClientOriginalName();
                    $savedPath = $this->saveUploadedFile($uploadedFile, $filename);

                    if ($savedPath) {
                        $savedFiles[] = $filename;
                    }
                }
            }

            // 3. Process uploaded attachment files
            $uploadedAttachmentFiles = $request->file('attachments', []);
            $uploadedAttachmentFiles = is_array($uploadedAttachmentFiles) ? $uploadedAttachmentFiles : [$uploadedAttachmentFiles];

            $savedAttachmentFiles = [];
            foreach ($uploadedAttachmentFiles as $uploadedFile) {
                if ($uploadedFile && $uploadedFile->isValid()) {
                    $filename = $uploadedFile->getClientOriginalName();
                    $savedPath = $this->saveAttachmentFile($uploadedFile, $filename);

                    if ($savedPath) {
                        $savedAttachmentFiles[] = $filename;
                    }
                }
            }

            // 4. Save documents (only if array is not empty)
            if (!empty($documentArray)) {
                DMSDocuments::insert($documentArray);
            }

            // 5. Save file metadata (only if array is not empty)
            if (!empty($fileArray)) {
                DMSFiles::insert($fileArray);
            }

            if (!empty($attachmentArray)) {
                DMSAttachment::insert($attachmentArray);
            }

            // 6. Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data processed successfully',
                'stats' => [
                    'documents_received' => count($documentArray),
                    'files_metadata_received' => count($fileArray),
                    'files_saved' => count($savedFiles)
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('DMS Upload Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function saveUploadedFile($uploadedFile, string $filename): ?string
    {
        $archiveDir = '/external1/swep_afd_storage/' . 'dms/';

        // Create directory if it doesn't exist
//        if (!file_exists($archiveDir)) {
//            mkdir($archiveDir, 0755, true);
//        }

        $fullPath = $archiveDir . $filename;

        try {
            if ($uploadedFile->move($archiveDir, $filename)) {
                return $fullPath;
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error saving file: ' . $e->getMessage());
            return null;
        }
    }

    private function saveAttachmentFile($uploadedFile, string $filename): ?string
    {
        $archiveDir = '/external1/swep_afd_storage/'. 'dms/attachment';

        // Create directory if it doesn't exist
//        if (!file_exists($archiveDir)) {
//            mkdir($archiveDir, 0755, true);
//        }

        $fullPath = $archiveDir . $filename;

        try {
            if ($uploadedFile->move($archiveDir, $filename)) {
                return $fullPath;
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error saving file: ' . $e->getMessage());
            return null;
        }
    }
}