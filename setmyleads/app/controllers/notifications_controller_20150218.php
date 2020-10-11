<?php

class NotificationsController extends AppController {

     var $name = 'Notifications';
     //var $components = array('Session');
     var $layout = 'livecalls';

     function index() {
          $this->Notification->recursive = 0;
          $this->paginate = array(
              "conditions" => array('statusid' => 1),
              'limit' => 100
          );
          $this->set('notifications', $this->paginate());
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid notification', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('notification', $this->Notification->read(null, $id));
     }

     function viewPdf($id = null) {
          if (!$id) {
               $this->Session->setFlash('Sorry, there was no property ID submitted.');
               $this->redirect(array('action' => 'index'), null, true);
          }
          //  Configure::write('debug', 2); // Otherwise we cannot use this method while developing

          $id = intval($id);

          //  $property = $this->Notification->read(null, $id); // here the data is pulled from the database and set for the view
          $property = array();
          $property = ('apple');
          //  if (empty($property)) {
          $this->Session->setFlash('Sorry, there is no property with the submitted ID.');
          //         $this->redirect(array('action' => 'index'), null, true);
          //      }

          $this->layout = 'pdf'; //this will use the pdf.ctp layout
          $this->render();
     }

}
