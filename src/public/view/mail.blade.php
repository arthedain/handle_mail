<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title data-form="subject">{{ __($subject)}}</title>

</head>

<body class="email-template" bgcolor="#e4e7e9"
      style="margin: 0;padding: 0;font-size: 100%;line-height: 1.6;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;width: 100%;height: 100%;">
<table class="bg" style="margin:0;padding:0;border-collapse:collapse;">
    <tr>
        <td class="bg-gray" width="2560" height="100%" bgcolor="#e4e7e9" align="center">
            <table class="body-wrap" align="center"
                   style="margin: 0;border-collapse: collapse;width: 100%;margin-top: 3%;padding: 0 10%;">
                <tr>
                    <td></td>
                    <td class="main-container" bgcolor="#FFFFFF" align="center"
                        style="margin:0 auto;padding:20px 40px 20px 40px;display:block;max-width:600px;clear:both;width:80%;-webkit-border-top-left-radius: 3px;-webkit-border-top-right-radius: 3px;-moz-border-radius-topleft: 3px;-moz-border-radius-topright: 3px;border-top-left-radius: 3px;border-top-right-radius: 3px;-webkit-box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.1);-moz-box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.1);box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.1);">
                        <table width="100%">
                            <tr>
                                <td align="center">
                                    <table>
                                        <tr>
                                            <td width="10%"></td>
                                            <td width="80%" align="center" valign="middle">
                                                <h2 style="font-size: 25px;">
                                                    {{__($subject)}}
                                                </h2>
                                            </td>
                                            <td width="10%"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="100%" align="center" valign="middle">
                                                <h3>
                                                    <table style="width: 500px;">
                                                        <tbody>
                                                        @foreach($content as $key => $item)
                                                            <tr>
                                                                <td align='right'>{{ __($key) }}</td>
                                                                <td>:</td>
                                                                <td>{{ $item }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" width="100%" height="20"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
            </table>
            <table class="brand-wrap" align="center"
                   style="margin: 0;padding: 0;border-collapse: collapse;width: 100%;margin-top: 0%;">
                <tr>
                    <td></td>
                    <td class="brand-container">
                        <div class="content" style="margin: 0 auto;padding: 0;max-width: 600px;display: block;">
                            <table width="100%" style="margin: 0;padding: 0;border-collapse: collapse;width: 100%;">
                                <tr>
                                    <td>
                                        <table style="margin: 0;padding: 0;border-collapse: collapse;width: 100%;">
                                            <tr>
                                                <td class="brand" align="center" valign="middle"
                                                    style="height: 100px;">
                                                    <a href="http://art-sites.org/" target="_blank"
                                                       style="text-decoration:none;border:0;"><img
                                                            class="template-img" width="120px"
                                                            src="http://images.art-sites.org/mail/blogo.png"
                                                            alt="Powered By Art Sites"
                                                            style="margin: 0;padding: 0;max-width: 100%;"
                                                            border="0" /></a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>

</html>
