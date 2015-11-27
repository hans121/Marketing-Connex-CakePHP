<?php
	$i=0;
	$sub_packages   = array();
	foreach ($packages as $package): 
    if($i < 4)
      $sub_packages[$i]   =   $package;
    $i++;
	endforeach;
?>

<div id="content" class="section-white-fade">
	<div class="container">

    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
		<?= $this->fetch('content') ?>
		
		<div class="row">
  		
  		<div class="col-centered col-lg-10 col-md-10 col-sm-10">
		
    		<h1 class="text-center"><?= __('Privacy & Cookies')?></h1>
    	
        <p><?= __('Panovus Marketing Limited is committed to protecting and respecting your privacy.')?></p>

        <p><?= __('This policy sets out the basis on which any personal data we collect from you, or that you provide to us, will be processed by us. For the purpose of the Data Protection Act 1998 (the "Act"), whenever we process your personal data we will be acting as a data controller unless we notify you to the contrary.')?></p>
        
        <h2><?= __('What we collect')?></h2>
        
        <p><?= __('We may collect and process information that you provide by filling in forms on our website www.marketingconnex.com (our website). This includes information provided at the time of registering to use our site, subscribing to our service(s), posting material or requesting further services or information. We may also ask you for information if you report a problem with our site.')?></p>
        
        <p><?= __('If you contact us, we may keep a record of that correspondence. We may also keep details of your visits to our site, including but not limited to traffic data, location data, weblogs and other communication data, whether this is required for our own billing purposes or otherwise and the resources that you access.')?></p>
        
        <p><?= __('We may collect information about your computer, including where available your IP address, operating system and browser type, for system administration and to report aggregate information to our advertisers. We may also keep a record of your email address.')?></p>
        
        <h2><?= __('Storage of your personal data')?></h2>
        
        <p><?= __('The data that we collect from you may be transferred to, and stored at, a destination outside the European Economic Area ("EEA"). It may also be processed by staff operating outside the EEA who work for us or for one of our suppliers. By submitting your personal data, you agree to this transfer, storing or processing. We will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this privacy policy.')?></p>
        
        <p><?= __('All information you provide to us is stored on secure servers. Although we will do our best to protect your personal data, we cannot guarantee the security of your data transmitted to our site; any transmission is at your own risk. Once we have received your information, we will use strict procedures and security features to try to prevent unauthorised access.')?></p>
        
        <h2><?= __('Uses made of the information')?></h2>
        
        <p><?= __('We will use information held about you in the following ways:')?></p>
        
        <ul>
          
          <li><?= __('to ensure that content from our site is presented in the most effective manner for you and for your computer;')?></li>
        
          <li><?= __('to provide you with information, products or services that you request from us or which we feel may interest you, where you have consented to be contacted for such purposes;')?></li>
        
          <li><?= __('to carry out our obligations arising from any contracts entered into between you and us;')?></li>
        
          <li><?= __('to allow you to participate in interactive features of our service, when you choose to do so;')?></li>
          
          <li><?= __('to notify you about changes to our service or website.')?></li>
          
        </ul>
        
        <p><?= __('We may also use your data, or permit selected third parties to use your data, to provide you with information about goods and services which may be of interest to you and we or they may contact you about these by post or telephone. If you are an existing customer, we will only contact you by electronic means (e-mail or SMS) with information about goods and services similar to those which were the subject of a previous sale to you. If you are a new customer, and where we permit selected third parties to use your data, we (or they) will contact you by electronic means only if you have consented to this.')?></p>
        
        <h2><?= __('Disclosure of your information')?></h2>
        
        <p><?= __('We may disclose your personal information to any member of our group, which means our subsidiaries, our ultimate holding company and its subsidiaries. We may disclose your personal information to third parties:')?></p>
        
        <ul>
          
          <li><?= __('in the event that we sell or buy any business or assets, in which case we may disclose your personal data to the prospective seller or buyer of such business or assets;')?></li>
        
          <li><?= __('if Panovus Marketing Limited or substantially all of its assets are acquired by a third party, in which case personal data held by it about its customers will be one of the transferred assets;')?></li>
        
          <li><?= __('if we are under a duty to disclose or share your personal data in order to comply with any legal obligation, or in order to enforce or apply our ')?><strong><?= $this->Html->link('Terms & Conditions', ['controller'=>'Pages','action' => 'terms'])?></strong><?= __('.')?></li>
          
        </ul>
        
        <h2><?= __('Information about our use of cookies')?></h2>
        
        <p><?= __('A cookie is a small file of letters and numbers that we store on your browser or the hard drive of your computer if you agree. Cookies contain information that is transferred to your computer\'s hard drive.')?></p>
        
        <p><?= __('Our website uses cookies to distinguish you from other users of our website. This helps us to provide you with a good experience when you browse our website and also allows us to improve our site. We use cookies to record website session information and do not use this information to identify any individual. By continuing to browse the site, you are agreeing to our use of cookies.')?></p>
        
        <p><?= __('We may from time to time use the following cookies:')?></p>
        
        <ul>
        
          <li><?= __('Strictly necessary cookies. These are cookies that are required for the operation of our website. They include, for example, cookies that enable you to log into secure areas of our website, use a shopping cart or make use of e-billing services.')?></li>
        
          <li><?= __('Analytical/performance cookies. They allow us to recognise and count the number of visitors and to see how visitors move around our website when they are using it. This helps us to improve the way our website works, for example, by ensuring that users are finding what they are looking for easily.')?></li>
        
          <li><?= __('Functionality cookies. These are used to recognise you when you return to our website. This enables us to personalise our content for you, greet you by name and remember your preferences (for example, your choice of language or region).')?></li>
        
          <li><?= __('Targeting cookies. These cookies record your visit to our website, the pages you have visited and the links you have followed. We will use this information to make our website and the advertising displayed on it more relevant to your interests. We may also share this information with third parties for this purpose.')?></li>
          
        </ul>
        
        <p><?= __('You can block cookies by activating the setting on your browser that allows you to refuse the setting of all or some cookies. However, if you use your browser settings to block all cookies (including essential cookies) you may not be able to access all or parts of our site.')?></p>
        
        <h2><?= __('Your rights')?></h2>
        
        <p><?= __('You have the right to ask us not to process your personal data for marketing purposes. If you do not want to receive communications from us in the future, please let us know by sending us an email or writing to us at the contact details set out at ')?><strong><?= $this->Html->link('Contact Us', ['controller'=>'Pages','action' => 'contact'])?></strong><?= __('.')?></p>
        
        <p><?= __('Our site may, from time to time, contain links to and from the websites of our partner networks, advertisers and affiliates. If you follow a link to any of these websites, please note that these websites have their own privacy policies and that we do not accept any responsibility or liability for these policies. Please check these policies before you submit any personal data to these websites.')?></p>
        
        <p><?= __('The Data Protection Act 1988 gives you the right to access information held about you. Your right of access can be exercised in accordance with the Act. Any access request may be subject to a fee of £10 to meet our costs in providing you with details of the information we hold about you.')?></p>
        
        <p><?= __('Any changes we may make to our privacy policy in the future will be posted on this page and, where appropriate, notified to you by e-mail.')?></p>
			
  		</div>
  		
		</div>
		
	</div> <!-- container(class)-->
</div>
