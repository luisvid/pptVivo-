<?php

class mailTemplate extends Render {
	
	static public function render($messageTitle, $messageContent){
		
		ob_start();
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=$messageTitle?></title>
		</head>
		
		<body bgcolor="#f1f1f2" link="#00b6f1" style="margin: 0; padding: 0; width: 100%; height: 100%; color: #666666;">
		<table cellpadding="0" cellspacing="0" border="0" width="658" align="center" bgcolor="#f1f1f2" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #666666;">
			<tr>
				<td valign="top">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td width="19" style="font-size: 0; line-height: 0;"></td>
						<td>
						<table width="620" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td width="620" height="19" style="font-size: 0; line-height: 0;"></td>
							</tr>
							<tr>
								<td height="78">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<tr>
										<td style="padding-left: 27px;" align="left">
											<a style="cursor: pointer;" href="<?=getCurrenProtocol()?>" target="_blank">
												<img height="75" width="152" border="0" alt=""
												src="<?=getCurrenProtocol()?>/core/img/html5/pptvivo.png" style="vertical-align: middle;">
											</a>
										</td>
										<td style="padding-right: 31px;" align="right">
										<table cellspacing="0" cellpadding="0" border="0">
											<tr>
												
											</tr>
										</table>
										</td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td width="620" height="10" style="font-size: 0; line-height: 0;"></td>
							</tr>
							<tr>
								<td style="background: #ffffff;">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<tr>
										<td width="26" style="font-size: 0; line-height: 0;"></td>
										<td>
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tr>
												<td width="568" height="32" style="font-size: 0; line-height: 0;"></td>
											</tr>
											<tr>
												<td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 17px; color: #666666;">
													<?=$messageContent?>
												</td>
											</tr>
											<tr>
												<td width="568" height="32" style="font-size: 0; line-height: 0;"></td>
											</tr>
										</table>
										</td>
										<td width="26" style="font-size: 0; line-height: 0;"></td>
									</tr>
								</table>
								</td>
							</tr>
							<tr>
								<td width="620" height="19" style="font-size: 0; line-height: 0;"></td>
							</tr>
						</table>
						</td>
						<td width="19" style="font-size: 0; line-height: 0;"></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</body>
		</html>
		
		<?php
		return ob_get_clean();
		
	}

} 
?>