<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
  		<title>Dissemination Log</title>

		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

		<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">

		<link rel="stylesheet" href="{{ asset('css/print.css') }}?s={{\Illuminate\Support\Str::random()}}">

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">

		<style type="text/css">

		.arrow {
			position: absolute;
			overflow: hidden;
			display: inline-block;
			font-size: 3px;
			width: 3em;
			height: 3em;
			border-top: 2px solid black;
			border-right: 2px solid black ;
			transform: rotate(54deg) skew(20deg);
		}

		.no-margin{
			margin: 0px;
		}

		.table{
			width: 100%;
		}
		.table td,th{
			padding: 0 5px;
			border: 1px solid black !important;
		}

		.table td:nth-child(3){
			width: 220px;
		}

		.table td:nth-child(4){
			width: 20%;
		}

		.table th{
			background-color: #179101;
			color : white;
		}

		body{
			font-size: 12px;
		}

		@media print {
			.table th{
				background-color: #179101 !important;
				color : white !important;
    			-webkit-print-color-adjust: exact; 
			}

			.blue{
				color: blue !important
			}
		}

		</style>
	</head>

{{--	<body onload="window.print()"  onafterprint="window.close()">--}}
	<body onload="window.print()">
	 	<div class="wrapper">
			<table style="width: 100%;">
				<tr>
					<td>
						<span style="font-size: 22px">
						<b>{{$document->reference_no}}</b>
						</span>
					</td>
					<td>
						<span style="font-size: 24px;text-align: center;" >
							{{$document->folder_code}}
							{{!empty($document->folder_code_2) ? ', '.$document->folder_code_2 : '' }}
						</span>
					</td>
				</tr>
			</table>

	 		<span class="no-margin blue" style="font-size: 22px">

			</span>
	 		<p class="no-margin">
				Document subject: <strong>{{$document->subject}}</strong>
			</p>
			<p class="no-margin">
				To: <strong>{{$document->person_to}}</strong>
			</p>
			<p class="no-margin">
				From: <strong>{{$document->person_from}}</strong>
			</p>

			<hr>
			@if(!empty($document->documentDisseminationLog))
				@php
					$emails = [];

					foreach ($document->documentDisseminationLogAll as $log) {
						if($log->status != "FAILED"){
							if(!isset($emails[$log->subject.'-'.$log->content])){
								$emails[$log->subject.'-'.$log->content]['subject'] = $log->subject;
								$emails[$log->subject.'-'.$log->content]['content'] = $log->content;
								$emails[$log->subject.'-'.$log->content]['logs'][$log->slug] = $log;
							}else{
								$emails[$log->subject.'-'.$log->content]['logs'][$log->slug] = $log;
							}
						}
					}

					//print("<pre>".print_r($emails,true)."</pre>");
				@endphp

				@foreach($emails as $key => $email)
					<p class="no-margin">
					Email subject: <strong>{{$email['subject']}}</strong>
					</p>

					<p class="no-margin">
						Email content: 
						<strong>
							{!! $email['content']  !!}
						</strong>
					</p>
					@php
						$sent = 0;
					@endphp
					<table class="table">
						<thead>
							<tr>
								<th>Fullname</th>
								<th>Received</th>
								<th>Email</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							
							@foreach($email['logs'] as $log)
								@php
									if($log->status == "SENT"){
										$sent++;
									}
								@endphp
								<tr>
									<td style="width: 30%">
										@if(!empty($log->emailContact))
											{{$log->emailContact->name}}
										@elseif(!empty($log->employee))
											{{$log->employee->lastname.', '.$log->employee->firstname}}
										@else
											<i>Contact not found</i>
										@endif

									</td>
									<td></td>
									<td>{{$log->email}}</td>
									<td>
										{!!$log->status == 'SENT' ? 
											'<b>SENT</b>' : 
											'<span class="text-danger">
												<b>FAILED</b></span>'!!}
											: {{ date("M. d, 'y | h:i A",strtotime($log->sent_at)) }}</td>
									
								</tr>
							@endforeach
						</tbody>
					</table>
					<br>
					<p class="no-margin pull-right">
						Total of: <b>{{count($email['logs'])}} email(s)</b>
					</p>
					<br>
					<p class="no-margin pull-right">{{$sent}} Sent | {{count($email['logs']) - $sent}} Failed </p>
					<hr>
				@endforeach
			@else

			@endif
	 	</div>
	</body>
</html>

