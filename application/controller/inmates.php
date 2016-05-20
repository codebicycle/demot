<?php

class Inmates extends Controller {

    public function index() {
		if(!isset($_SESSION))
		{
			session_start();
		}
		if(!isset($_SESSION['admin_id']))
		 {
			header('location: ' . URL . 'admins/login');
			die();	
		 }
        $inmates = $this->model->getAllInmates();
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function add() {
		if(!isset($_SESSION))
		{
			session_start();
		}
		if($_SESSION['rank']==1)
		{
			$InstId=$this->model->getInstId_by_id($_SESSION['admin_id']);
		}
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/add.php';
        require APP . 'view/_templates/footer.php';
    }
	
	public function search() {
		$institutions=$this->model->getAllInstitutions();
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/search_form.php';
        require APP . 'view/_templates/footer.php';
    }
	
	public function find()
	{
		if(!$_POST || !isset($_POST['search'])) {
            header('location: ' . URL . 'inmates/search');
            return;
		}
        $institutions = $this->model->getAllInstitutions();
		$FirstName = $_POST['FirstName'];
		$LastName = $_POST['LastName'];
		$InstId =  $this->model->InstId = $_POST['InstId'];
		$DOB = $this->model->DOB = $_POST['DOB'] ?? null;

        // validate
        if ($DOB) {
            Validator::validate_date($this->model, 'DOB');
        }
        Validator::validate_institutionId_exists($this->model, 'InstId');
        if ($this->model->validation_errors) {
            // redisplay filled form
            require APP . 'view/_templates/header.php';
            require APP .  'view/inmates/search_form.php';
            die();
        }

		$inmate = $this->model->find_inmate_by_name($FirstName, $LastName, $InstId, $DOB);
		if($inmate)
		{
			if(count($inmate)>1 && empty($DOB))
			{	
				$this->model->validation_errors['MoreInmates'] = "More than one inmates match this query. Make sure the name is complete and fill in inmate's date of birth.";
				$show_dob_field = true;
				require APP . 'view/_templates/header.php';
				require APP .  'view/inmates/search_form.php';
			}
			else if(count($inmate)>1 && !empty($DOB))
			{

				$this->model->validation_errors['MoreInmates'] = "There are more inmates with this name and date of birth at this institution. Please make this appointment by phone.";
				require APP . 'view/_templates/header.php';
				require APP .  'view/inmates/search_form.php';
			}
			else if(count($inmate)===1) 
			{
				//nu aveam sesiune aici
				session_start();
				$_SESSION['inmateid']=$inmate[0]->Id;		
				header('location: ' . URL . 'appointments/add');
			}
		}
		else 
		{
			$this->model->validation_errors['MoreInmates'] = "No inmate found with these credentials";
			require APP . 'view/_templates/header.php';
			require APP .  'view/inmates/search_form.php';
		}
	}

    public function create() {
        if(!$_POST || !isset($_POST['Create'])) {
            header('location: ' . URL . 'inmates/add');
            return;
        }

        $inmate = $this->model;
        $inmate->initialize(
            null,
            $_POST['FirstName'],
            $_POST['LastName'],
            $_POST['CNP'],
            $_POST['DOB'],
            $_POST['InstId'],
            $_POST['Crime'],
            $_POST['Sentence'],
            $_POST['IncarcerationDate'],
            $_POST['ReleaseDate'],
            $_POST['LawyerFirstName'],
            $_POST['LawyerLastName'],
            $_POST['LawyerCNP'],
            null );

        $success = $inmate->save();

        if ($success) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        else {
            // redisplay filled form and validation hints
            $validation_errors = $inmate->validation_errors;
            require APP . 'view/_templates/header.php';
            require APP . 'view/inmates/add.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function delete($id) {
        $success = $this->model->destroy($id);
        if ($success) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        else {
            // TODO: add flash message
            header('location: ' . URL . 'errorz/index');
            die();
        }
    }

    public function edit($id) {
        // find id in database
        // show form and populate fields
        $inmate = $this->model->find_by_id($id);
        $cache = (array) $inmate;
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/edit.php';
        require APP . 'view/_templates/footer.php';
    }

    public function update($id) {
        if(!$_POST || !isset($_POST['Update'])) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        $inmate = $this->model;
        $inmate->initialize(
            $id,
            $_POST['FirstName'],
            $_POST['LastName'],
            $_POST['CNP'],
            $_POST['DOB'],
            $_POST['InstId'],
            $_POST['Crime'],
            $_POST['Sentence'],
            $_POST['IncarcerationDate'],
            $_POST['ReleaseDate'],
            $_POST['LawyerFirstName'],
            $_POST['LawyerLastName'],
            $_POST['LawyerCNP'],
            $_POST['LawyerId'] );

        $success = $inmate->update($inmate->Id);
        
        if ($success) {
            header('location: ' . URL . 'inmates/index');
            die();
        }
        else {
            // redisplay filled form and validation hints
            $validation_errors = $inmate->validation_errors;
            require APP . 'view/_templates/header.php';
            require APP . 'view/inmates/edit.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function edit_rights($id) {
        $inmate = $this->model->find_by_id($id);
        $ban_end_date = $this->model->ban_end_date($id);
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/inmates/edit-rights.php';
        require APP . 'view/_templates/footer.php';
    }

    public function ban($id, $string_period) {
        $whitelist = ['1week', '1month', '3months'];
        $dict = ['1week' => '+1 week',
                '1month' => '+1 month',
                '3months' => '+3 month'];

        if (in_array($string_period, $whitelist)) {
            $result = $this->model->ban($id, $dict[$string_period]);
        } 
            
        header('location: ' . URL . 'inmates/edit_rights/' . $id);
        die();
    }

    public function lift_ban($id) {
        $this->model->lift_ban($id);
        header('location: ' . URL . 'inmates/edit_rights/' . $id);
        die();
    }

    public function increment($id) {
        $this->model->increment_visits($id);
        header('location: ' . URL . 'inmates/edit_rights/' . $id);
        die();
    }

     public function decrement($id) {
        $this->model->decrement_visits($id);
        header('location: ' . URL . 'inmates/edit_rights/' . $id);
        die();
    }
}
