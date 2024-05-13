<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Demystifying Email Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style type="text/css">
        a[x-apple-data-detectors] {color: inherit !important;}

        button:hover {
            -webkit-transition: initial;
            transition: initial;
            background-color: green;
        }

        .td-style{
            color: #153643; font-family: Arial, sans-serif; font-size: 14px; line-height: 24px; padding: 0px 0 0px 0;
        }
        .bold{
            font-weight: bold;
        }
    </style>

</head>
<body style="margin: 0; padding: 0;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 20px 0 30px 0;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc;">
                <tr>
                    <td align="center" bgcolor="#eaffe3" style="padding: 40px 0 30px 0;">
                        <img src="http://drive.google.com/uc?export=view&id=1jdZO7Mo4DefwDhrqdMOkVAdBVI9e-HQN" alt="Creating Email Magic." width="150" height="150" style="display: block;" />
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table id='details' border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; padding-bottom: 15px" colspan="2">
                                    <h1 style="font-size: 18px; margin: 0;">New ICT Service Request was made.</h1>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-style">
                                    <p style="margin: 0;">Nature of Request:</p>
                                </td>
                                <td class="td-style">
                                    <p style="margin: 0;" class="bold">{{$r->nature_of_request}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-style">
                                    Details :
                                </td>
                                <td class="td-style bold">
                                    {{$r->request_details}}
                                </td>
                            </tr>
                            <tr>
                                <td class="td-style">
                                    Requisitioner:
                                </td>
                                <td class="td-style bold">
                                    {{strtoupper($user->employee->firstname)}} {{strtoupper($user->employee->lastname)}}
                                </td>
                            </tr>
                            <tr>
                                <td class="td-style">
                                    Request No:
                                </td>
                                <td class="td-style bold">
                                    {{$r->request_no}}
                                </td>
                            </tr>
                            <tr>
                                <td class="td-style">
                                    Created at:
                                </td>
                                <td class="td-style bold">
                                    {{\Illuminate\Support\Carbon::parse($r->created_at)->format('F d, Y | h:i A')}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-top: 20px">
                                    <a href="{{route('dashboard.mis_requests.index')}}?find={{$r->request_no}}">Click here for details.</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                                    <p style="margin: 0;">&reg;SRA WEB PORTAL 2021<br/>
                                </td>
                                <td align="right">
                                    <!-- <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                      <tr>
                                        <td>
                                          <a href="http://www.twitter.com/">
                                            <img src="https://assets.codepen.io/210284/tw.gif" alt="Twitter." width="38" height="38" style="display: block;" border="0" />
                                          </a>
                                        </td>
                                        <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                        <td>
                                          <a href="http://www.twitter.com/">
                                            <img src="https://assets.codepen.io/210284/fb.gif" alt="Facebook." width="38" height="38" style="display: block;" border="0" />
                                          </a>
                                        </td>
                                      </tr>
                                    </table> -->
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>

<script type="text/javascript">

</script>
</html>