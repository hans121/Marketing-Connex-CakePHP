<?php
namespace App\Controller;
use App\Controller\AppController;
use App\Form\ContactForm;


class ContactController extends AppController
{
	public function beforeFilter(Event $event) {
	  parent::beforeFilter($event);
	  // Allow free access.
	  $this->Auth->allow(['index', 'contact']);
	  $this->layout = 'frontend';
	}
	
	public function index() {
	  $contact = new ContactForm();
	  if ($this->request->is('post')) {
	      if ($contact->execute($this->request->data)) {		
			// Form Saver
			$this->loadModel('ContactFormSubmissions');
			
			$ip = $this->request->env('REMOTE_ADDR');
			$agent = $this->request->env('HTTP_USER_AGENT');
			
			$this->request->data['ip_address'] = $ip;
			$this->request->data['browser_agent'] = $agent;
			
			$contact_form_data = $this->ContactFormSubmissions->newEntity($this->request->data);
			$this->ContactFormSubmissions->save($contact_form_data);
			// Form Saver
			
	        $this->redirect('/pages/thank-you/');

	      } else {

	        $this->Flash->error('There was a problem submitting your form. Please ensure you have included your name and a valid email address.');
	      }
	  }
	  $this->set('contact', $contact);
		
	}
	
    public function contact()
    {
	  $contact = new ContactForm();
	  if ($this->request->is('post')) {
	      if ($contact->execute($this->request->data)) {			  
			// Form Saver
			$this->loadModel('ContactFormSubmissions');
			
			$ip = $this->request->env('REMOTE_ADDR');
			$agent = $this->request->env('HTTP_USER_AGENT');
			
			$this->request->data['ip_address'] = $ip;
			$this->request->data['browser_agent'] = $agent;
			
			$contact_form_data = $this->ContactFormSubmissions->newEntity($this->request->data);
			$this->ContactFormSubmissions->save($contact_form_data);
			// Form Saver
			
	        $this->redirect('/pages/thank-you/');

	      } else {

	        $this->Flash->error('There was a problem submitting your form.');
	      }
	  }
	  $this->set('contact', $contact);

    }
	
    
}
