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
					$tablehead = array("<html><p class=\"title\">Visits Per Institution</p>
    <table border=1>
        <thead>
            <tr>
				<td>Visits</td>
                <td>Name</td>
				<td>Location</td>
                
            </tr>
        </thead>
        <tbody>\n");
					$this->model->export_visits($visits_per_institution,'visits',$tablehead);
					
				}
				else if($_POST['function']==="most_visited")
				{
					$tablehead = array("<html><p class=\"title\">Most Visited</p>
    <table border=1>
        <thead>
            <tr>
				<td>Visits</td>
                <td>First Name</td>
				<td>Last Name</td>
				<td>Name</td>
				<td>Location</td>
				<td>Emotional state (avg)</td>
				<td>Physical state (avg)</td>
				<td>Duration(minutes)</td>             
            </tr>
        </thead>
        <tbody>\n");

					$this->model->export_visits($most_visited,'most_visited',$tablehead);
				}
				else if($_POST['function']==="most_visitors_visits")
				{
					$tablehead = array("<html><p class=\"title\">Most active visitors</p>
    <table border=1>
        <thead>
            <tr>
				<td>Visits</td>
                <td>First Name</td>
				<td>Last Name</td>
                
            </tr>
        </thead>
        <tbody>\n");
					
					
					$this->model->export_visits($most_visitors_visits,'most_visitors_visits',$tablehead);
				}
				else if($_POST['function']==="most_banned_inmates")
				{
					$tablehead = array("<html><p class=\"title\">Most banned inmates</p>
    <table border=1>
        <thead>
            <tr>
				<td>Number of bans</td>
                <td>First Name</td>
				<td>Last Name</td>
				<td>Institution name</td>
				<td>Institution location</td>
                
            </tr>
        </thead>
        <tbody>\n");
					
					
					$this->model->export_visits($most_banned_inmates,'most_banned_inmates',$tablehead);
				}
				else if($_POST['function']==="active_guards")
				{
					$tablehead = array("<html><p class=\"title\"Most active guards</p>
    <table border=1>
        <thead>
            <tr>
				<td>Actions</td>
                <td>User Name</td>
				<td>Institution name</td>
				<td>Institution location</td>
                
            </tr>
        </thead>
        <tbody>\n");				
					
					$this->model->export_visits($active_guards,'active_guards',$tablehead);
				}
				else if($_POST['function']==="average_visit_duration")
				{
					$tablehead = array("<html><p class=\"title\">Average visit duration</p>
    <table border=1>
        <thead>
            <tr>
				<td>Duration (minutes)</td>
                <td>Name</td>
				<td>Location</td>
                
            </tr>
        </thead>
        <tbody>\n");
					$this->model->export_visits($average_visit_duration,'average_visit_duration',$tablehead);
				}
				else if($_POST['function']==="popular_hour")
				{
					$tablehead = array("<html><p class=\"title\">Popular visiting  hour</p>
    <table border=1>
        <thead>
            <tr>
				<td>Number</td>
                <td>Hour</td>   	   
            </tr>
        </thead>
        <tbody>\n");
					$this->model->export_visits($popular_hour,'popular_hour',$tablehead);
				}
			}
				
		}
		else if($_SESSION['rank']==1)
		{
		
			
			
			
		}			
		require APP . 'view/_templates/header.php';
        require APP . 'view/statistics/index.php';
        require APP . 'view/_templates/footer.php';
    }

   
}
