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
		
    		<h1 class="text-center"><?= __('Terms of Use')?></h1>
    	
        <p class="text-center"><strong><?= __('PLEASE READ THESE TERMS OF USE CAREFULLY BEFORE USING THIS SITE')?></strong></p>
    
        <p><?= __('The terms of use tell you the terms on which our website ')?><strong><?= $this->Html->link('www.marketingconnex.com', ['controller'=>'Pages','action' => 'home'])?></strong><?= __(' may be used, Use of our website includes accessing, browsing, registering your details or providing information or data.')?></p>
    
        <p><?= __('Please read the terms of use carefully. By using our website, you confirm that you accept these terms of use and that you agree to comply with them. If you do not agree to these terms of use, you must not use our site.')?></p>
    
        <p><?= __('In addition, Our ')?><strong><?= $this->Html->link('Privacy & Cookie Policy', ['controller'=>'Pages','action' => 'privacy'])?></strong><?= __(' sets out the terms on which we process any personal data collected from you, or that provided to us by you. By using our site, you warrant that all data provided by you is accurate and additionally you consent to such processing.')?>
        <p><?= __('www.marketingconnex.com is a website operated by Panovus Marketing Limited. Panovus is registered as a company in England and Wales, number 08445082. Our registered office is: The Granary, Courtyard Barns, Cookham Dean, SL6 6PT.')?></p>
    
        <h2><?= __('Our website')?></h2>
    
        <p><?= __('We may update our website from time to time, and may change the content at any time. However, we do not guarantee that our website, or any content in it, will be free from errors or omissions. We will make reasonable efforts to keep the information on our site updated, but we do not make any representations, warranties or guarantees, whether express or implied, that the content on our website is accurate, complete or up-to-date.')?></p>
    
        <p><?= __('Access to our site is permitted on a temporary basis. We do not guarantee that our website, or any content in it, will always be available or will be uninterrupted. We may suspend, withdraw, discontinue or change all or any part of the website without notice. We will not be liable to you for any reason if our website is unavailable at any time or for any period, however short or long.')?></p>
    
        <p><?= __('You are responsible for making all required arrangements for you and/or your organisation to have access to our website. You are also responsible for ensuring that all persons who access our website through your internet connection are aware of these terms of use and other applicable terms and conditions, and that they agree to and comply with them.')?></p>
    
        <p><?= __('The content on our site is provided for general information only. It is not intended to amount to advice on which you should rely.')?></p>
    
        <h2><?= __('Intellectual property rights')?></h2>
    
        <p><?= __('Panovus Marketing Limited is the owner and/or the rights-holder of all intellectual property rights, including copyrights, related to our website, and in the material published in it. All such rights are reserved. We do not warrant that the content of our site does not infringe any third party intellectual property rights.')?></p>
    
        <p><?= __('You may print off one copy, and may download extracts, of any page(s) from our site for your personal use and you may draw the attention of others within your organisation to content posted on our site. However, you must not modify the paper or digital copies of any materials you have printed off or downloaded in any way, and you must not use any illustrations, photographs, video or audio sequences or any graphics separately from any accompanying text.')?></p>
    
        <p><?= __('Our status (and that of any identified contributors) as the authors of content on our site must always be acknowledged. You must not use any part of the content on our site for commercial purposes without obtaining a licence to do so from us or our licensors. If you print off, copy or download any part of our site in breach of these terms of use, your right to use our site will cease immediately and you must, at our option, return or destroy any copies of the materials you have made.')?></p>
    
        <h2><?= __('Limitation of our liability')?></h2>
    
        <p><?= __('Nothing in these terms of use excludes or limits our liability for death or personal injury arising from our negligence, or our fraud or fraudulent misrepresentation, or any other liability that cannot be excluded or limited by English law.')?></p>
    
        <p><?= __('When you use our website, you do so at your own risk. To the extent permitted by law, we exclude all conditions, warranties, representations or other terms which may apply to our website or any content in it, whether express or implied. We will not be liable to any user for any loss or damage, whether in contract, tort (including negligence), breach of statutory duty, or otherwise, even if foreseeable, arising under or in connection with:')?></p>
    
        <ul>
      
          <li><?= __('use of, or inability to use, our website; or')?></li>
      
          <li><?= __('use of or reliance on any content displayed on our site.')?></li>
      
        </ul>
    
        <p><?= __('For business users, Please note that we will not be liable for loss of profits, sales, business, or revenue, business interruption, loss of anticipated savings, loss of business opportunity, goodwill or reputation, or any indirect or consequential loss or damage.')?></p>
    
        <p><?= __('For consumer users, please note that we only provide our site for domestic and private use. You agree not to use our site for any commercial or business purposes, and we have no liability to you for any loss of profit, loss of business, business interruption, or loss of business opportunity.')?></p>
    
        <p><?= __('We will not be liable for any loss or damage caused by a virus, distributed denial-of-service attack, or other technologically harmful material that may infect your computer equipment, computer programs, data or other proprietary material due to your use of our website or due to you downloading  any content from or on it, or from or on on any website linked to it.')?></p>
    
        <p><?= __('We assume no responsibility for the content of websites linked on our site. Such links should not be interpreted as endorsement by us of those linked websites. We will not be liable for any loss or damage that may arise from your use of them.')?></p>
    
        <h2><?= __('Viruses')?></h2>
    
        <p><?= __('We do not guarantee that our site will be secure or free from bugs or viruses. You are responsible for configuring your information technology, computer programs and/or platform in order to access our site. You should use your own virus protection software at all times.')?></p>
    
        <p><?= __('You must not misuse our site by knowingly introducing viruses, trojans, worms, logic bombs or other material which is or may be malicious or technologically harmful. You must not attempt to gain unauthorised access to our site, the server on which our site is stored or any server, computer or database connected to our site. You must not attack our site via a denial-of-service attack or a distributed denial-of service attack.')?></p>
    
        <p><?= __('By breaching this provision, you would commit a criminal offence under the Computer Misuse Act 1990. We will report any such breach to the relevant law enforcement authorities and we will co-operate with those authorities by disclosing your identity to them. In the event of such a breach, your right to use our website will cease immediately.')?></p>
    
        <h2><?= __('Linking to our site and third party links and resources')?></h2>
    
        <p><?= __('You may link to our home page, provided you do so in a way that is fair and legal and does not damage our reputation or take advantage of it. You must not establish a link in such a way as to suggest any form of association, approval or endorsement on our part where none exists. You must not establish a link to our site in any website that is not owned by you. Our site must not be framed on any other site, nor may you create a link to any part of our site other than the home page. The website in which you are linking must comply in all respects with the content standards set out below.')?></p>
    
        <p><?= __('We reserve the right to withdraw linking permission without notice.')?></p>
    
        <p><?= __('Where our site contains links to other sites and resources provided by third parties, these links are provided for your information only. We have no control over the contents of those sites or resources and accept no responsibility or any liabilities for them.')?></p>
    
        <h2><?= __('Prohibited Uses')?></h2>
    
        <p><?= __('You may use our site only for lawful purposes. You may not use our site:')?></p>
    
        <ul>
          
          <li><?= __('in any way that breaches any applicable local, national or international law or regulation;')?></li>
        
          <li><?= __('in any way that is unlawful or fraudulent, or has any unlawful or fraudulent purpose or effect;')?></li>
        
          <li><?= __('for the purpose of harming or attempting to harm minors in any way;')?></li>
        
          <li><?= __('to send, knowingly receive, upload, download, use or re-use any material which does not comply with our required content standards;')?></li>
        
          <li><?= __('to transmit, or procure the sending of, any unsolicited or unauthorised advertising or promotional material or any other form of similar solicitation (spam);')?></li>
        
          <li><?= __('to knowingly transmit any data, send or upload any material that contains viruses, Trojan horses, worms, time-bombs, keystroke loggers, spyware, adware or any other harmful or malicious programs or similar computer code designed to adversely affect the operation of any computer software or hardware.')?></li>
          
        </ul>
    
        <h2><?= __('Interactive Services')?></h2>
    
        <p><?= __('We may from time to time provide interactive services on our site, including, without limitation, chat rooms and bulletin boards (interactive services).')?></p>
    
        <p><?= __('Where we do provide any interactive service, we will provide clear information to you about the kind of service offered, if it is moderated and what form of moderation is used (including whether it is human or technical). We will do our best to assess any possible risks for users from third parties when they use any interactive service provided on our site, and we will decide in each case whether it is appropriate to use moderation of the relevant service (including what kind of moderation to use) in the light of those risks. However, we are under no obligation to oversee, monitor or moderate any interactive service we provide on our site, and we expressly exclude our liability for any loss or damage arising from the use of any interactive service by a user in contravention of our content standards, whether the service is moderated or not. Where we do moderate an interactive service, we will normally provide you with a means of contacting the moderator, should a concern or difficulty arise.')?></p>
    
        <h2><?= __('Uploading Content to our Site')?></h2>
    
        <p><?= __('Whenever you make use of a feature that allows you to upload content to our site, or to make contact with other users of our site, you must comply with our required content standards.')?></p>
  
        <p><?= __('You warrant that any such contribution complies with those standards, and you will be liable to us and indemnify us for any breach of that warranty. If you are a consumer user, this means you will be responsible for any loss or damage we suffer as a result of your breach of warranty')?>.</p>
    
        <p><?= __('We also have the right to disclose your identity to any third party who is claiming that any content posted or uploaded by you to our site constitutes a violation of their intellectual property rights, or of their right to privacy.')?></p>
        
        <p><?= __('We will not be responsible, or liable to any third party, for the content or accuracy of any content posted by you or any other user of our site. We have the right to remove any posting you make on our site if, in our opinion, your post does not comply with our content standards.')?></p>
        
        <p><?= __('The views expressed by other users on our site do not represent our views or values.<')?>/p>
        
        <h2><?= __('Content Standards')?></h2>
        
        <p><?= __('These content standards apply to any and all material which you contribute to our site, and to any interactive services associated with it. The standards apply to each part of any contribution as well as to its whole.')?></p>
        
        <p><?= __('Contributions must:')?></p>
        
        <ul>
          
          <li><?= __('be accurate (where they state facts);')?></li>
        
          <li><?= __('be genuinely held (where they state opinions);')?></li>
        
          <li><?= __('comply with applicable law in the UK and in any country from which they are posted.')?></li>
          
        </ul>
        
        <p><?= __('Contributions must not:')?></p>
        
        <ul>
          
          <li><?= __('contain any material which is defamatory of any person;')?></li>
        
          <li><?= __('contain any material which is obscene, offensive, hateful or inflammatory;')?></li>
        
          <li><?= __('promote sexually explicit material;')?></li>
        
          <li><?= __('promote violence;')?></li>
        
          <li><?= __('promote discrimination based on race, sex, religion, nationality, disability, sexual orientation or age;')?></li>
        
          <li><?= __('infringe any copyright, database right or trade mark of any other person;')?></li>
        
          <li<?= __('>be likely to deceive any person;')?></li>
        
          <li><?= __('be made in breach of any legal duty owed to a third party, such as a contractual duty or a duty of confidence;')?></li>
        
          <li><?= __('promote any illegal activity;')?></li>
        
          <li><?= __('be threatening, abuse or invade another’s privacy, or cause annoyance, inconvenience or needless anxiety;')?></li>
        
          <li><?= __('be likely to harass, upset, embarrass, alarm or annoy any other person;')?></li>
        
          <li><?= __('be used to impersonate any person, or to misrepresent your identity or affiliation with any person;')?></li>
        
          <li><?= __('give the impression that they emanate from us, if this is not the case;')?></li>
        
          <li><?= __('advocate, promote or assist any unlawful act such as (by way of example only) copyright infringement or computer misuse.')?></li>
          
        </ul>
        
        <h2><?= __('Applicable law')?></h2>
        
        <p><?= __('These Terms of Use, their subject matter and formation (and any non-contractual disputes or claims) are governed by English law and are under the exclusive jurisdiction of the courts of England and Wales.')?></p>
			
		  </div>
			
    </div>
			
			
	</div> <!-- container(class)-->
</div>
