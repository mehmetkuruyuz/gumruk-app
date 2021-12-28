<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style></style>
    </head>
    <body>
    	<p style='font-family:arial;font-size:14px;'></p>
        <table border="0" cellpadding="0" cellspacing="0" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="15" cellspacing="0" id="emailContainer">
                        <tr>
                            <td align="left" valign="top" style='font-family:arial;font-size:11px;'><strong><?php echo e(trans('messages.registerfirmaname')); ?></strong></td>
                            <td align="left" valign="top" style='font-family:arial;font-size:10px;'><?php echo e($data['fullname']); ?></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style='font-family:arial;font-size:11px;'><strong>Email</strong></td>
                            <td align="left" valign="top" style='font-family:arial;font-size:11px;'><?php echo e($data['email']); ?></td>
                        </tr>
                        <tr>
                        	<td align="left" valign="top" style='font-family:arial;font-size:11px;'><strong><?php echo e(trans('messages.messagecontent')); ?></strong></td>
                            <td align="left" valign="top" style='font-family:arial;font-size:11px;'><?php echo $data['mesaj']; ?></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style='font-family:arial;font-size:11px;'><strong><?php echo e(trans('messages.updateddate')); ?></strong></td>
                            <td align="left" valign="top" style='font-family:arial;font-size:11px;'><?php echo e($data['zaman']); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
