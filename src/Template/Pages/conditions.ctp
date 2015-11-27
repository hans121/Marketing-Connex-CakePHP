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
		
    		<h1 class="text-center"><?= __("Service Agreement – Terms & Conditions")?></h1>
    	
        <p><?= __("This service agreement is a legal agreement between you and Panovus Marketing Limited of The Granary, Courtyard Barns, Cookham, Dean, SL6 6PT ('Panovus' or 'we') for this marketingconneX software as a service product (SAAS), which includes computer software and related printed materials or other documentation (including any presented electronically or online).") ?></p>

        <p><?= __("This service agreement is made and entered into as of the effective date of the first order executed between Panovus and you, described in such order form. You should carefully read the terms of this service agreement before signing an order. Clicking ‘accept ‘and/or accepting and/or accessing or using any services or software of Panovus confirms that you have read, understood and accept the service agreement terms. Any agreement with you with respect to the marketingconneX SAAS is expressly limited to this service agreement and is based on your express consent thereof. The terms and conditions of this service agreement shall govern the service(s) to be provided by Panovus under any order form submitted by you and accepted by Panovus, as though the provisions of this service agreement were set forth in their entirety within such order form, and so that each order form and this service agreement shall be considered one, fully integrated document and agreement. The term 'Panovus' shall include any third parties which are providing third party services identified in an order form. The term ‘you’ shall include you, your employees and any of your contracted third party marketing and/or channel partners who use this software and/or service on your behalf.") ?></p>

<ol>
  
  <li><strong><?= __("Grant and scope of licence")?></strong>
    <ol>
      <li><?= __("In consideration of you agreeing to abide by the terms of this service agreement, Panovus Marketing Limited (“Panovus”) hereby grants to you a non-exclusive, non-transferable licence to use the SAAS and any documentation relating to the same (“Documentation”) on the terms of this service agreement.")?></li>
      <li><?= __("You may:")?>
        
          <p>(a) <?= __("access and use the SAAS for your internal business purposes only")?><br />
          (b) <?= __("receive and use any free supplementary software code or update of the SAAS incorporating 'patches' and corrections of errors as may be provided by Panovus from time to time;")?><br />
          (c)<?= __("use any Documentation in support of the use permitted under condition 1.1 and make one copy of the Documentation for back-up purposes only.")?></p>
        
      </li>
      <li><?= __("Panovus reserves the right to make changes, modifications and enhancements to the SAAS and Terms and Conditions of 	use from time to time, including, but not limited to, the addition of functionality and third party integrations 	for which 	additional charges may be required for their subscription and use.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Licensee's undertakings")?></strong>
    <ol>
      <li><?= __("Except as expressly set out in this Service agreement or as permitted by any local law, you undertake:")?>
        <p>(a) <?= __("not to copy the SAAS or associated  documentation except where such copying is incidental to normal use of the SAAS or where it is necessary for the purpose of back-up or operational security;")?><br />
(b) <?= __("not to rent, lease, sub-license, sell, re-sell, transfer, assign, loan, translate, merge, adapt, vary or modify the SAAS or documentation;")?><br />
(c) <?= __("not to make alterations to, or modifications of, the whole or any part of the SAAS nor permit the SAAS or any part of it to be combined with, or become incorporated in, any other programs;")?><br />
(d) <?= __("not to disassemble, de-compile, reverse engineer or create derivative works based on the whole or any part of the SAAS nor attempt to do any such things except to the extent that (by virtue of section 296A of the Copyright, Designs and Patents Act 1988) such actions cannot be prohibited because they are essential for the purpose of achieving inter-operability of the SAAS with another software program, and provided that the information obtained by you during such activities:")?></p>
<p>(i) <?= __("is used only for the purpose of achieving inter-operability of the SAAS with another software program;")?><br />
(ii) <?= __("is not disclosed or communicated without Panovus's prior written consent to any third party to whom it is not necessary to disclose or communicate it; and")?><br />
(iii) <?= __("is not used to create any software or other service which is substantially similar to the SAAS;")?></p>
<p>(e) <?= __("where relevant, to keep all copies of the SAAS secure;")?><br />
(f) <?= __("to supervise and control use of the SAAS and ensure that the SAAS is used by your employees and representatives in accordance with the terms of this service agreement;")?><br />
(g) <?= __("not to provide, or otherwise make available, the SAAS in any form, in whole or in part to any person other than your employees or contracted marketing or channel partners in connection with programs and services available to your third party marketing or channel partners without prior written consent from Panovus;")?></p>
      </li>
      <li><?= __("You must permit Panovus and its representatives, at all reasonable times and on reasonable advance notice, to inspect and have access to any premises, and to the computer equipment located there, at which the SAAS or the documentation is being kept or used, and any records kept pursuant to this service agreement, for the purpose of ensuring that you are complying with the terms of this service agreement.")?></li>
      <li><?= __("You, your employees or contracted marketing or channel partners shall not use the SAAS to: (i) send spam or otherwise duplicative or unsolicited messages in violation of applicable laws; (ii) send or store infringing, obscene, threatening, libellous, or otherwise unlawful or tortious material, including material harmful to children or violate third party privacy rights; (iii) send or store material containing software viruses, worms, Trojan horses or other harmful computer code, files, scripts, agents or programs; (iv) interfere with or disrupt the integrity or performance of the Service or the data contained therein; or (v) attempt to gain unauthorized access to the service or Software or its related systems or networks.")?></li>
      <li><?= __("You are responsible for all activity occurring under your user accounts and shall abide by all applicable local, state, national and foreign laws, treaties and regulations in connection with your use of the SAAS, including those related to data privacy, international communications and the transmission of technical or personal data.")?></li>
      <li><?= __("You shall: (i) notify Panovus as soon as practical of any unauthorized use of any password, or account or any other known or suspected breach of security with respect to the SAAS; (ii) as soon as practical report to Panovus and use reasonable efforts to stop any copying or distribution of Content that is known or suspected by you or your authorised users; and (iii) not impersonate another Panovus user or provide false identity information to gain access to or use the SAAS.")?></li>
      <li><?= __("You agree that you will comply with all applicable laws and regulations in connection with your use of the SAAS including but not limited to, all applicable privacy and export control laws and regulations.")?></li>
      <li><?= __("You represent that you are not an individual less than 18 years of age.")?></li>
      <li><?= __("You grant Panovus the right to use your name, mark and logo on Panovus’s website, in Panovus marketing materials, and to identify you as a Panovus Customer.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Intellectual property rights")?></strong>
    <ol>
      <li><?= __("You acknowledge that all intellectual property rights in the SAAS and the documentation and any suggestions, ideas, enhancements and feedback provided to Panovus by you throughout the world regarding these belong to Panovus, that rights in the SAAS are licensed (not sold) to you, and that you have no rights in, or to, the SAAS or the documentation other than the right to use them in accordance with the terms of this service agreement.")?></li>
      <li><?= __("You acknowledge that you have no right of access to the SAAS in source code form or in unlocked coding or with comments. The integrity of the SAAS is protected by technical protection measures (TPM) so that the intellectual property rights, including copyright, in the SAAS are not misappropriated.  You must not attempt in any way to remove or circumvent any such TPM, nor to apply, manufacture for sale, hire, import, distribute, sell, nor let, offer, advertise or expose for sale or hire, nor have in your possession for private or commercial purposes, any means whose sole intended purpose is to facilitate the unauthorised removal or circumvention of such TPM.")?></li>
      <li><?= __("The name and logo of marketingconneX are trademarks of Panovus and no right or service agreement is granted to you to use them.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Order Process")?></strong>
    <ol>
      <li><?= __("You shall order the service by completing and signing an order form. Panovus shall accept or reject such order form within five (5) days.")?></li>
      <li><?= __("Each accepted, fully executed order form shall become incorporated herein by reference.")?></li>
      <li><?= __("In the event that your business practices require a purchase order number be issued prior to payment of any Panovus invoices issued pursuant to this order form, then such purchase order number must be entered by you.")?></li>
      <li><?= __("Your execution and return of this order form to Panovus without designating a purchase order number shall be deemed an acknowledgement that no purchase order number is required for payment of invoices hereunder.")?></li>
      <li><?= __("Additionally, terms, provisions or conditions on any purchase order, acknowledgement, or other business form or writing that you may use in connection with the provision of SAAS by Panovus will have no effect on the rights, duties or obligations of the parties hereunder, regardless of any failure of Panovus to object to such terms, provisions or conditions.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Account Information and Data")?></strong>
    <ol>
      <li><?= __("Panovus does not own any of your data.")?></li>
      <li><?= __("You, not Panovus, shall have sole responsibility for the accuracy, quality, integrity, legality, reliability, appropriateness, and intellectual property ownership or right to use all your data, and Panovus shall not be responsible or liable for the deletion, correction, destruction, damage, loss or failure to store any of your data, especially caused by your incorrect usage of the SAAS.")?></li>
      <li><?= __("In the event this service agreement is terminated (other than by reason of your breach under clause10), Panovus will make available to you a file of your data if requested by you within thirty (30) days of termination.")?></li>
      <li><?= __("You agree and acknowledges that (i) Panovus is not obligated to retain your data for longer than thirty (30) days after termination, and (ii) Panovus has no obligation to retain your data, and may delete your data, if you have materially breached this service agreement, including but not limited to failure to pay outstanding fees, and such breach has not been cured within ten (10) days of notice of such breach.")?></li>
      <li><?= __("Upon termination for cause resulting from an uncured breach, your right to access or use your data immediately ceases, and Panovus shall have no obligation to maintain or forward any of your data.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Charges and Payment of Fees")?></strong>
    <ol>
      <li><?= __("You shall pay all fees or charges as specified on each executed order form.")?></li>
      <li><?= __("All payment obligations are non-cancellable and all amounts paid are non-refundable.")?></li>
      <li><?= __("Panovus reserves the right to modify its fees and charges and to introduce new charges at any time, upon at least thirty (30) days prior notice, as specified in clause 13 below to you, effective upon the next renewal term in accordance with clause 7, below. In the event that you do not cancel as described in clause 13 below, such changes shall become effective at the commencement of the renewal term.")?></li>
      <li><?= __("Neither party will disclose any pricing terms or other terms of this service agreement to anyone other than its lawyers, accountants, and other professional advisors under a duty of confidentiality except (a) as required by law, or (b) pursuant to a mutually agreeable press release.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Term, Billing and Renewal")?></strong>
    <ol>
      <li><?= __("The initial term of this service agreement shall begin on the effective date of the first order form signed and/or as agreed 	by you by clicking accept on the order form and as agreed between the parties.")?></li>
      <li><?= __("The commencement of each service shall begin on the order form effective date which describes the service in 	question.")?></li>
      <li><?= __("In the event that an order form contains services added to an existing subscription, such added services shall be run in 	parallel with the initial or renewal term and shall be billed from the order form effective date.")?></li>
      <li><?= __("Panovus charges and collects in advance for the committed amounts as defined on each order form. You will pay all 	invoices on acceptance by Panovus of the order Form, unless otherwise agreed in writing. Unless terminated as described 	in Section 13, upon expiration of the Initial term of any order form, or upon expiration of any renewal term as 	specified 	herein, such order form shall automatically renew for an additional one (1) year period.")?></li>
      <li><?= __("Panovus’s fees are exclusive of all taxes, levies, or duties imposed by taxing authorities, and you shall be responsible for 	payment of all such taxes, levies, or duties, excluding only taxes based solely on Panovus's income.")?></li>
      <li><?= __("You will be billed, and payments will be made, in a designated currency provided by the SAAS. If you believe your invoice 	is incorrect, you must contact Panovus in writing within five (5) days of the date of the invoice containing the 	amount in 	question to be eligible to receive an adjustment or credit.")?></li>
      <li><?= __("If payment is made via credit card, the credit card is chargeable upon the invoice date and no receipt will be provided.")?></li>
      <li><?= __("Panovus reserve the right to invoice you directly in the event that reasonable efforts made to obtain a credit card 	payment authorization fail.")?></li>
      <li><?= __("You agree to provide Panovus with accurate billing and contact information, including your legal company name, street 	address, e-mail address, and name and telephone number of an authorized billing contact and Administrator.")?></li>
      <li><?= __("You agree to update your contact and billing information within thirty (30) days of any change to it.")?></li>
      <li><?= __("If the contact or billing information you have provided is false or fraudulent, Panovus reserves the right to terminate your access to the Service in addition to any other legal remedies.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Non-payment and Suspension")?></strong>
    <ol>
      <li><?= __("In addition to any other rights granted to Panovus herein, Panovus reserves the right to suspend or terminate this service 	 period of thirty (30) days.")?></li>
      <li><?= __("Delinquent invoices are subject to interest of 1.5% per month on any outstanding balance, or the maximum permitted by 	law, whichever is less, from the date due, plus all expenses of collection.")?></li>
      <li><?= __("You will continue to be charged for License fees during any period of service suspension.")?></li>
      <li><?= __("If Panovus initiates termination of this service agreement for cause, as further described in clause 10, you will be 	obligated to pay 	the balance due on order form(s) then in effect computed in accordance with clause 7 above, 	provided, however, that any such order form shall expire at the end of the initial term or then-current renewal term.")?></li>
      <li><?= __("You agree that Panovus may charge such unpaid fees to your credit card or otherwise bill you for such unpaid fees.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Termination upon Expiration/Reduction in Commitment Level")?></strong>
    <ol>
      <li><?= __("Either party may terminate any order form or, in the case of you, deactivate modules, for such order form upon written 	notice delivered to the other party no later than thirty (30) days prior to the expiration of the initial term or then-current 	renewal term of such order form.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Termination for Cause")?></strong>
    <ol>
      <li><?= __("Either party may terminate this service agreement (and any order forms then in effect) if the other party breaches any 	material 	term of this service agreement which, in the case of you, will include any breach of your payment obligations or 	unauthorized use by you or your employees or contracted marketing partners of the marketingconneX Technology or 	SAAS or if the other party fails to cure such breach within thirty (30) business days after notice of such breach.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Warranty")?></strong>
    <ol>
      <li><?= __("Panovus warrants that:")?>
        <p>(a) <?= __("from the date of your first use of the SAAS, the service and/or Software will, when properly used, perform substantially in accordance with the functions described in the documentation, and the documentation correctly describes the operation of the SAAS in all material respects; and")?><br />
          (b) <?= __("it has tested the SAAS for viruses using commercially available virus-checking software, consistent with current industry practice.")?></p>
      </li>
      <li><?= __("You acknowledge that:")?>
        <p>(a) <?= __("it is your responsibility to ensure that the facilities and functions of the SAAS as described in the documentation meet your requirements.")?><br />
          (b) <?= __("the SAAS may not be free of bugs or errors and you agree that the existence of any minor errors shall not constitute a breach of this service agreement.")?>
        </p>
      </li>
      <li><?= __("If, you notify Panovus in writing of any defect or fault in the SAAS in consequence of which it fails to perform substantially in accordance with the documentation, and such defect or fault does not result from you having amended the service or SAAS or used it in contravention of the terms of this service agreement, Panovus will, at its sole option, repair the SAAS, provided that you make available all information that may be necessary to assist Panovus in resolving the defect or fault, including sufficient information to enable Panovus to recreate the defect or fault.")?></li>
      <li><?= __("The SAAS may be subject to limitations, delays and other problems, including unlawful hacking of its programs, 	systems and unlawful access to stored data, inherent in the use of the internet and electronic communications. Panovus 	is not responsible for delays, delivery failures or other damage resulting from any such problems.")?></li>
      <li><?= __("Except as provided in clause 12, Panovus and its Licensors make no representation, warranty or guarantee as to the reliability, timeliness, quality, suitability, truth, availability, accuracy or completeness of the SAAS or any content or programming.   Panovus and its Licensors do not represent or warrant that")?>
      <p>(a) <?= __("the use of the SAAS will be 	secure, timely, uninterrupted or error-free or operate in combination with any other hardware, software, system or data,")?><br />
        (b) <?= __("the SAAS will meet requirements or expectations,")?><br />
        (c) <?= __("any stored data will be accurate or reliable,")?><br />
        (d) <?= __("the quality of any products, services, information or other material purchased or obtained through the SAAS will meet expectations or requirements")?><br />
        (e) <?= __("errors or defects will be corrected, or")?><br />
        (f) <?= __("the SAAS or server(s) that make the service available are free from viruses or other harmful components.")?></p>
      </li>
      <li><?= __("The SAAS and all content is provided to you on an ‘as is’ basis. All conditions, representations, warranties, whether express or implied, statutory or otherwise, including without limitation any implied warranty of merchantability, fitness for a particular purpose or non-infringement of third party rights are hereby disclaimed to the maximum extent permitted by applicable law by Panovus and by its Licensors.")?></li>

    </ol>
  </li>

  <li><strong><?= __("Licensor's Liability")?></strong>
    <ol>
      <li><?= __("Nothing in this service agreement shall exclude or in any way limit Panovus's liability for fraud, or for death and 	personal injury caused by its negligence, or any other liability to the extent that it cannot be excluded or limited as a matter of law.")?></li>
      <li><?= __("Subject to clause 12.1, Panovus shall not be liable under or in connection with this service agreement or any collateral contract for loss of income, loss of business profits or contracts, business interruption, loss of the use of money or anticipated savings, loss of information, loss of opportunity, goodwill or reputation, loss of, damage to or corruption of data, or any indirect or consequential loss or damage of any kind howsoever arising and whether caused by tort (including negligence), breach of contract or otherwise; provided that this clause 12.2 shall not prevent claims for loss of or damage to your tangible property that fall within the terms of condition 11 or any other claims for direct financial loss that are not excluded by any of the aforementioned categories of this clause 12.2.")?></li>
      <li><?= __("Subject to clauses 12.1 and 12.2 above, Panovus's maximum aggregate annual liability under or in connection with this 	service agreement, or any collateral contract, whether in contract, tort (including negligence) or otherwise, shall be 	limited to a sum equal to the service agreement fees for the SAAS paid by you during the twelve (12) months 	immediately preceding the date upon which the cause of action arose.")?></li>
      <li><?= __("Subject to clauses 12.1, 12.2 and 12.3, Panovus's liability for infringement of third party intellectual property rights shall 	be limited to breaches of rights subsisting in the UK.")?></li>
      <li><?= __("This service agreement sets out the full extent of Panovus's obligations and liabilities in respect of the supply of the 	SAAS.  In particular, there are no conditions, warranties, representations or other terms, 	express or implied, that are 	binding on Panovus except as specifically stated in this service agreement.  Any 	condition, warranty, representation or 	other term concerning the supply of the SAAS and documentation which might otherwise be implied into, or incorporated 	in this service agreement, or any collateral contract, 	whether by statute, common law or otherwise, is hereby excluded to 	the fullest extent permitted by law.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Termination")?></strong>
    <ol>
      <li><?= __("Panovus may terminate this service agreement immediately by written notice to you if:")?><br />
        <p>(a) <?= __("You commit a material or persistent breach of this service agreement which you fail to remedy (if remediable) within 14 days after the service on you of written notice requiring you to do so; or")?><br />
        (b) <?= __("a petition for a bankruptcy order to be made against you has been presented to the court; or")?><br />
         (c)<?= __("you become insolvent or unable to pay your debts (within the meaning of section 123 of the Insolvency Act 1986 or other applicable national legislation ), enter into liquidation, whether voluntary or compulsory (other than for reasons of bona fide amalgamation or reconstruction), pass a resolution for your winding-up, have a receiver or administrator manager, trustee, liquidator or similar officer appointed over the whole or any part of your assets, make any composition or arrangement with your creditors or take or suffer any similar action in consequence of your debt, or becomes unable to pay your debts (within the meaning of section 123 of the Insolvency Act 1986 or other applicable national legislation).")?></p>
      </li>
      <li><?= __("This service agreement shall terminate automatically on the termination of the subscription or expiry of any other agreed 	statement of work, unless otherwise agreed by Panovus in writing")?></li>
      <li><?= __("Upon termination for any reason:")?><br />
      <p>(a) 	<?= __("all rights granted to you under this service agreement shall cease;")?><br />
(b) <?= __("you must cease all activities authorised by this service agreement;")?><br />
(c) <?= __("you must immediately pay to Panovus any sums due to Panovus under this service agreement; and
you must immediately delete or remove access to the SAAS from all computer equipment in your possession and immediately destroy or return to Panovus (at Panovus's option) all copies of the SAAS or documentation then in your possession, custody or control and, in the case of destruction, certify to Panovus that you have done so.")?></p>
      </li>
    </ol>
  </li>
 
 <li><strong><?= __("Transfer of rights and obligations")?></strong>
  <ol>
   <li><?= __("This service agreement is binding on you and us and on our respective successors and assigns.")?></li>
   <li><?= __("You may not transfer, assign, charge or otherwise dispose of this service agreement, or any of your rights or obligations 	arising under it, without Panovus’s prior written consent.")?></li>
   <li><?= __("Panovus may transfer, assign, charge, sub-contract or otherwise dispose of this service agreement, or any of his rights or 	obligations arising under it, at any time during the term of the service agreement.")?>
   </li>
  </ol>
 </li>
  
  <li><strong><?= __("Notices")?></strong>
    <ol>
      <li><?= __("All notices given by you to Panovus must be given to Panovus Marketing Limited, The Granary,
Courtyard Barns, Cookham Dean, SL6 6PT")?></li>
      <li><?= __("Panovus may give notice to you at either the e-mail or postal address provided by you in the order form, when first 	registering for use of the SAAS, or otherwise.")?></li>
      <li><?= __("Notice will be deemed received and properly served 24 hours after an e-mail is sent, or three days after the date of posting of any letter. In proving the service of any notice, it will be sufficient to prove, in the case of a letter, that such letter was properly addressed, stamped and placed in the post and, in the case of an e-mail, that such e-mail was sent to the specified e-mail address of the addressee.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Events outside Panovus's control")?></strong>
    <ol>
      <li><?= __("Panovus will not be liable or responsible for any failure to perform, or delay in performance of, any of his obligations under 	this service agreement that is caused by an event outside its reasonable control (Force Majeure Event).")?></li>
      <li><?= __("A Force Majeure Event includes any act, event, non-happening, omission or accident beyond our reasonable control and 	includes in particular (without limitation) the following: acts of God, including but not limited to fire, flood, earthquake, 	windstorm or other natural disaster; war, threat of or preparation for war, armed conflict, imposition of sanctions, embargo, 	breaking off of diplomatic relations or similar actions; terrorist attack, civil war, civil commotion or riots; nuclear, chemical 	or biological contamination or sonic boom; mandatory compliance with any law; fire, explosion or accidental damage; loss 	at sea; extreme adverse weather conditions; collapse of building structures, failure of plant machinery, machinery, c	omputers or vehicles; any labour dispute, including but not limited to strikes, industrial action or lockouts; and interruption 	or failure of utility service, including but not limited to electric power, gas or water.")?></li>
      <li><?= __("Panovus's performance under this service agreement is deemed to be suspended for the period that the Force Majeure 	Event continues, and he will have an extension of time for performance for the duration of that period. Panovus will use its 	reasonable endeavours to bring the Force Majeure Event to a close or to find a solution by which its obligations under this 	service agreement may be performed despite the Force Majeure Event.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Waiver")?></strong>
    <ol>
      <li><?= __("If Panovus fails, at any time during the term of this service agreement, to insist on strict performance of any of your 	obligations under 	this service agreement, or if Panovus fails to exercise any of the rights or remedies to which it is entitled 	under this service agreement, this shall not constitute a waiver of such rights or remedies and shall not relieve you 	from 	compliance with such obligations.")?></li>
      <li><?= __("A waiver by Panovus of any default shall not constitute a waiver of any subsequent default.")?></li>
      <li><?= __("No waiver by Panovus of any of these terms and conditions shall be effective unless it is expressly stated to be a waiver 	and is communicated to you in writing.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Severability")?></strong>
    <ol>
      <li><?= __("If any of the terms of this service agreement are determined by any competent authority to be invalid, unlawful or 	unenforceable to 	any extent, such term, condition or provision will to that extent be severed from the remaining terms, 	conditions and provisions which will continue to be valid to the fullest extent permitted by law.")?>
</li>
    </ol>
  </li>
  
  <li><strong><?= __("Entire agreement")?></strong>
    <ol>
      <li><?= __("This service agreement and any document expressly referred to in it represents the entire agreement between us in 	relation to the licensing of the SAAS and documentation and supersedes any prior agreement, understanding or 	arrangement between us, whether oral or in writing.")?></li>
      <li><?= __("We each acknowledge that, in entering into this service agreement, neither of us has relied on any representation, 	undertaking or promise given by the other or implied from anything said or written in negotiations between us before 	entering into this 	service agreement except as expressly stated in this service agreement.")?></li>
      <li><?= __("Neither of us shall have any remedy in respect of any untrue statement made by the other, whether orally or in writing, 	prior to the date we entered into this service agreement (unless such untrue statement was made fraudulently) and the 	other party's only remedy shall be for breach of contract as provided in this service agreement.")?></li>
    </ol>
  </li>
  
  <li><strong><?= __("Law and jurisdiction")?></strong>
    <ol>
      <li><?= __("This service agreement, its subject matter or its formation (including non-contractual disputes or claims) shall be governed 	by and construed in accordance with English law and submitted to the exclusive jurisdiction of the English courts.")?></li>
    </ol>
  </li>
  
</ol>



			
		  </div>
			
    </div>
			
			
	</div> <!-- container(class)-->
</div>
