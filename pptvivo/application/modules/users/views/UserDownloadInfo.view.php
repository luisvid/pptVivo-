<?php
class UserDownloadInfo extends Render {
	
	public static function render() {
		ob_start();
		?>

		<ul>
			<li>1.	Download the installer file 
				<a href="/downloads/pptVivoSetup.exe" class="download-button">here</a>.
			</li>
			<li>2.	If prompted, click "Run" or "Save".</li>
			<li>3.	If you have saved the installer, double-click the installer file pptVivoSetup.exe to start the installation process. You may receive a warning that pptVivo! Add in is an application downloaded from the Internet. Click the Open button.</li>
			<li>4.	If asked to allow the program to make changes to your computer, please click the Yes button..</li>
			<li>5.	Sometimes, depending on your system, the Microsoft .Net Framework and / or the Microsoft tools for Office may need to be updated, if that is the case, please follow the installer instructions.</li>
			<li>6.	Complete the installation package instructions.</li>
			<li>7.	Once the install routine has finished, you'll find the new pptVivo! ribbon in Microsoft PowerPoint.</li>
		</ul>
		<br>
		
		<h2>How to use the pptVivo! Ribbon on Microsoft PowerPoint</h2>

		<img src="/core/img/downloadinfo/ribbon.png" width="781" height="187" alt="The pptVivo! ribbon" />
		<br>
		<br>
		<br>
		
		<ul>
			<li>1.	Shows you a form to enter your User name and Password so you can login to your pptVivo! account. (Note: you must be logged to pptVivo! before opening a presentation to synchronize)</li>
			<li>2.	Opens your favorite browser and goes to pptvivo.com so you can configure your account options.</li>
		</ul>
		The following features are no yet implemented in the pptVivo! ribbon but these actions can be carried out from Presentations Management at pptvivo.com.
		<ul>
			<li>3.	Creates the Exposition for the current presentation in order to setup the pptVivo! viewer so you can share it with your audience and they can follow it from their devices.</li>
			<li>4.	Uploads the current presentation to your account at pptvivo.com.</li>
			<li>5.	Gives you a short URL pointing to your presentation Viewer. You can share it with your audience so they can follow your presentation.</li>
			<li>6.	Gives you an image of a QR code that redirects to your presentation Viewer. You can show it to your audience so they can scan it and follow your presentation.</li>
			<li>7.	Shows you the list of questions asked by the audience during the presentation..</li>
		</ul>

		<br>
                   
		<?
		return ob_get_clean();
	}
}
