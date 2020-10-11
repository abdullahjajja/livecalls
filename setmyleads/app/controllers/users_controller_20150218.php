<?php

class UsersController extends AppController {

     var $name = 'Users';
     var $uses = array('User', 'Country', 'State', 'City', 'AccountsUser', 'PayoneerUser', 'WireUser', 'UserType');
     var $helpers = array('Html', 'Form', 'Ajax', 'Javascript');
     var $components = array('RequestHandler');
     var $layout = 'livecalls';

     function beforeFilter() {
          $this->Auth->autoRedirect = false;
          parent::beforeFilter();
          //$this->Auth->allow(array('testcalls'));
     }

     /*
       function login() {
       $this->layout = 'login';
       print $this->data['User']['password'];
       }
      */

     function login() {
          if ($this->Auth->user('isdeleted') == 1) {
               $this->layout = 'login';
               $this->Session->setFlash('Yours Account is Deactivated.');
               $this->redirect($this->Auth->logout());
          }
          if ($this->Auth->user('role_id') == '6') {
               $this->set('authUser', $this->Auth->user('role_id'));
               $this->redirect(array('controller' => 'reports', 'action' => 'testcalls'));
          } elseif ($this->Auth->user('role_id') == '1' || $this->Auth->user('role_id') == '2' || $this->Auth->user('role_id') == '3' || $this->Auth->user('role_id') == '4') {
               //$this->redirect($this->Auth->redirect());
               return $this->redirect(array('controller' => 'news'));
          } else {
               $this->layout = 'login';
               print $this->data['User']['password'];
          }
     }

     function logout() {
          $this->layout = 'login';
          $this->Session->setFlash('Logged Out Successfully');
          $this->redirect($this->Auth->logout());
     }

     function index($id = null) {
          if (isset($_GET['id'])) {
               $id = $_GET['id'];
          } else {
               $id = null;
          }
          if (isset($_GET['email'])) {
               $email = $_GET['email'];
          } else {
               $email = null;
          }
          if (isset($_GET['name'])) {
               $name = $_GET['name'];
          } else {
               $name = null;
          }



          // echo $id;
          //exit;
          $this->User->recursive = 0;

          if ($this->Auth->user('role_id') == '1') {
               if ($id != null) {
                    $this->set('users', $this->paginate(null, array('User.role_id = ' => 2, 'AND' => array('User.login LIKE ' => "%" . $id . "%"))));
               } elseif ($name != null) {
                    $this->set('users', $this->paginate(null, array('User.role_id = ' => 2, 'AND' => array('User.first_name LIKE ' => "%" . $name . "%"))));
               } elseif ($email != null) {
                    $this->set('users', $this->paginate(null, array('User.role_id = ' => 2, 'AND' => array('User.email LIKE ' => "%" . $email . "%"))));
               } else {
                    //$this->paginate = array('limit' => 100);
                    $this->paginate = array('order' => array('User.login' => 'asc'), 'limit' => 100);
                    $this->set('users', $this->paginate(null, array('User.role_id > ' => $this->Auth->user('role_id'), 'AND' => array('User.role_id = ' => 2))));
               }
          } else {
               if ($id != null) {
                    $this->set('users', $this->paginate(null, array('User.created_by = ' => $this->Auth->user('id'), 'AND' => array('User.login LIKE ' => "%" . $id . "%"))));
               } elseif ($name != null) {
                    $this->set('users', $this->paginate(null, array('User.created_by = ' => $this->Auth->user('id'), 'AND' => array('User.first_name LIKE ' => "%" . $name . "%"))));
               } elseif ($email != null) {
                    $this->set('users', $this->paginate(null, array('User.created_by = ' => $this->Auth->user('id'), 'AND' => array('User.email LIKE ' => "%" . $email . "%"))));
               } else {
                    $this->paginate = array('order' => array('User.login' => 'asc'), 'limit' => 100);
                    $this->set('users', $this->paginate(null, array('User.role_id > ' => $this->Auth->user('role_id'), 'AND' => array('User.created_by = ' => $this->Auth->user('id')))));
               }
          }
          $this->set('userrole', $this->Auth->user('role_id'));
     }

     function view($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid user', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->set('user', $this->User->read(null, $id));
     }

     function add() {
          if (!empty($this->data)) {
               if ($this->Auth->user('role_id') == 1) {
                    //     $this->data['User']['email'] == 2;
                    //   $this->Question->Visitor->findByEmail($this->data['Question']['email']);
                    //  $pending = $this->Article->find('count', array('conditions' => array('Article.status' => 'pending')));
                    if (isset($this->data['User']['email'])) {

                         $email = $this->data['User']['email'];
                         $count = $this->User->find('count', array('conditions' => array('User.email' => $email, 'User.role_id' => '2')));
                         //  $count = $this->User->find('count', array('conditions' => array('User.role_id' => '2', 'User.email' => email)));
                         if ($count > 0) {
                              $this->Session->setFlash('Unable To create User Email Already Exist . Try Again with some other emiail');
                              $this->redirect(array('action' => 'add'));
                         }
                    }
               }
               $this->User->create();
               $this->data['User']['created_by'] = $this->Auth->user('id');
               if ($this->User->save($this->data)) {

                    if ($this->data['User']['role_id'] == 2) {
                         $uid = $this->User->id;

                         $query = "INSERT INTO accounts_users(`user_id`,`currency_id`) VALUE ($uid,1),($uid,2),($uid,4);";
                         $this->AccountsUser->query($query, $cachequeries = false);

                         $query2 = "INSERT INTO wire_users(`user_id`) VALUE ($uid);";
                         $this->WireUser->query($query2, $cachequeries = false);
                         $query3 = "INSERT INTO payoneer_users(`user_id`) VALUE ($uid);";
                         $this->PayoneerUser->query($query3, $cachequeries = false);
                         $this->Session->setFlash(__('The user has been saved ', true));
                    }

                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
               }
          }
          $countries = $this->User->Country->find('list');
          $usertype = $this->User->UserType->find('list');

          $countries[0] = '--Select--';
          ksort($countries);
          //$states = $this->User->State->find('list');
          $states[0] = '--Select--';
          ksort($states);
          //$cities = $this->User->City->find('list');
          $cities[0] = '--Select--';
          ksort($cities);
          $roles = $this->User->Role->find('list', array('conditions' => array('Role.id =' => $this->Auth->user('role_id') + 1)));
          $this->set(compact('countries', 'states', 'cities', 'roles', 'usertype'));
     }

     function edit($id = null) {
          if (!$id && empty($this->data)) {
               $this->Session->setFlash(__('Invalid user', true));
               $this->redirect(array('action' => 'index'));
          }
          if (!empty($this->data)) {
               // die(print_r($this->data));
               if ($this->User->save($this->data)) {
                    $this->Session->setFlash(__('The user has been saved', true));
                    $this->redirect(array('action' => 'index'));
               } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
               }
          }
          if (empty($this->data)) {
               $this->data = $this->User->read(null, $id);
               $countries = $this->User->Country->find('list');
               $countries[0] = '--Select--';
               ksort($countries);
               $states = $this->User->State->find('list', array('conditions' => array('State.country_id = ' => $this->data['User']['country_id'])));
               $states[0] = '--Select--';
               ksort($states);
               $cities = $this->User->City->find('list', array('conditions' => array('City.state_id = ' => $this->data['User']['state_id'])));
               $cities[0] = '--Select--';
               ksort($cities);
          }
          $usertype = $this->User->UserType->find('list');
          $roles = $this->User->Role->find('list', array('conditions' => array('Role.id =' => $this->Auth->user('role_id') + 1)));
          $this->set(compact('countries', 'states', 'cities', 'roles', 'usertype'));
     }

     function delete($id = null) {
          if (!$id) {
               $this->Session->setFlash(__('Invalid id for user', true));
               $this->redirect(array('action' => 'index'));
          }
          $this->User->updateAll(
                  array('User.isdeleted' => 1), array('User.id' => $id)
          );
          //  if($this->User->delete($id)) {
          $this->Session->setFlash(__('User Deactivated', true));
          $this->redirect(array('action' => 'index'));
          //}
          $this->Session->setFlash(__('User was not Deactivated', true));
          $this->redirect(array
              ('action' => 'index'));
     }

     function selectstates() {
          $this->autoRender = false;
          $this->layout = 'ajax';
          $this->State->recursive = 0;
          $state = $this->State->find('all', array('conditions' => array('State.country_id =' => $_GET['cid'])));
          $cities = "<div class=\"input select\">
           <label for=\"UserStateId\">State</label>
           <select id=\"UserStateId\" onchange=\"getCities()\" name=\"data[User][state_id]\">
           <option value=\"0\">--Select--</option>";
          foreach ($state as $key):
               $cities = $cities . "<option value='" . $key['State']['id'
                       ] . "'> " . $key['State']['name'] . "</option>";
          endforeach;
          echo $cities . "</select></div>";
     }

     function selectcities() {
          $this->autoRender = false;
          $this->layout = 'ajax';
          $state = $this->City->find('all', array('conditions' => array('City.state_id =' => $_GET['sid'])));

          $cities = "<div class=\"input select\">
           <label for=\"UserCityId\">City</label>
           <select id=\"UserCityId\" name=\"data[User][city_id]\">
           <option value=\"0\">--Select--</option>";
          foreach ($state as $key):
               $cities = $cities . "<option value='" . $key['City'][
                       'id'] . "'> " . $key['City']['name'] . "</option>";
          endforeach;
          echo $cities . "</select></div>";
     }

     function filteruser($name) {
          echo $name;
          $this->User->recursive = 0;
          if ($this->Auth->user('role_id') == '1') {
               $this->set('users', $this->paginate(null, array('User.role_id > ' => $this->Auth->user('role_id'), 'AND' => array('User.role_id = ' => 2), 'AND' => array('User.login = ' => $name))));
          } else {

               $this->set('users', $this->paginate(null, array('User.role_id > ' => $this->Auth->user('role_id'), 'AND' => array('User.created_by = ' => $this->Auth->user('id'), 'AND' => array('User.login = ' => $name)))));
          }
          $this->set('userrole', $this->Auth->user('role_id'));
     }

}

