<?php

class Statistics extends Controller {

    public function index() 
	{
		session_start();			
		if($_SESSION['rank']==0)
		{
			$visits_per_institution=$this->model->get_visits_per_institution();
			$most_visited=$this->model->get_visited_inmates();
			$most_visitors_visits=$this->model->get_visitors_visits();
			$most_banned_inmates=$this->model->get_banned_inmates();
			$active_guards =$this->model->get_most_active_guard();
			$average_visit_duration=$this->model->get_average_visit_duration();
			$popular_hour=$this->model->get_popular_hour();		
			
			if(isset($_POST['function']))
			{
				if($_POST['function']==="visits_per_institution")
				{
					$this->model->export_visits($visits_per_institution,'visits');
					
				}
				else if($_POST['function']==="most_visited")
				{
					$this->model->export_visits($most_visited,'most_visited');
				}
				else if($_POST['function']==="most_visitors_visits")
				{
					$this->model->export_visits($most_visitors_visits,'most_visitors_visits');
				}
				else if($_POST['function']==="most_banned_inmates")
				{
					$this->model->export_visits($most_banned_inmates,'most_banned_inmates');
				}
				else if($_POST['function']==="active_guards")
				{
					$this->model->export_visits($active_guards,'active_guards');
				}
				else if($_POST['function']==="average_visit_duration")
				{
					$this->model->export_visits($active_guards,'average_visit_duration');
				}
				else if($_POST['function']==="popular_hour")
				{
					$this->model->export_visits($active_guards,'popular_hour');
				}
			}
				
		}
				
		
		require APP . 'view/_templates/header.php';
        require APP . 'view/statistics/index.php';
        require APP . 'view/_templates/footer.php';
    }

   
}
