<?php 

class Validator {

    private static function validate($model, $key, $pattern, $message, $err_label) {
        if(!preg_match($pattern, $model->$key)) {
            $model->validation_errors[$err_label ?? $key] = $message;
        }
    }
	
	
	public static function validate_email($model, $key) {
        $message ="Please fill in a valid E-mail.";
        $result = filter_var(
            $model->$key, 
            FILTER_VALIDATE_EMAIL);
        if ($result === false) {
            $model->validation_errors[$key] = $message; 
        }
    }

	
	public static function validate_passwords_match($model, $key1, $key2)
	{
		$pwd = $model->$key1;
		$rpwd = $model->$key2;
		$message="Passwords does not match.";
		if($pwd!==$rpwd)
		{	
			$model->validation_errors[$key1] = $message; 
			$model->validation_errors[$key2] = $message; 
		}
	}
	
    public static function validate_name($model, $key, $err_label=null) {
        $pattern = "/^[- 'a-zA-Z]{2,50}$/";
        $message = "Only letters, spaces, minus and single quote characters are permitted. Must have two or more characters.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    public static function validate_cnp($model, $key, $err_label=null) {
        $pattern = "/\d{13}/";
        $message = "Please fill in a valid CNP.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    private static function is_valid_date($input) {
        $pattern = "/^(\d{4})[-\/ .]?(\d{1,2})[-\/ .]?(\d{1,2})$/";
        if (preg_match($pattern, $input, $matches)) {
            if(checkdate($matches[2], $matches[3], $matches[1])) {
                return true;
            }
        }
        return false;
    }

    public static function validate_date($model, $key, $err_label=null) {
        $message = "Please fill in a valid date.";
        if (Validator::is_valid_date($model->$key))
            return;
        $model->validation_errors[$err_label ?? $key] = $message;
    }

    public static function validate_date_not_in_future ($model, $key, $err_label=null) {
        $message = "Date can not be in the future.";
        $date = $model->$key;
        if(Validator::is_valid_date($date) &&
            strtotime($date) < time() )
            return;
        $model->validation_errors[$err_label ?? $key] = $message;
    }
	
	 public static function validate_date_not_in_past ($model, $key, $err_label=null) {
        $message = "Date can not be in the past.";
        $date = $model->$key;
        if(Validator::is_valid_date($date) &&
            strtotime($date) > time() )
            return;
        $model->validation_errors[$err_label ?? $key] = $message;
    }
	public static function validate_date_no_more_than ($model, $key, $err_label=null) {
		$message = "Date can not be in the future with more than 3 months.";
        $date = $model->$key;
		 if(Validator::is_valid_date($date) &&
            strtotime($date) < strtotime("+3 months") )
            return;
        $model->validation_errors[$err_label ?? $key] = $message;
	}
    public static function is_date1_before_date2($date1, $date2) {
        return strtotime($date1) <= strtotime($date2);
    }

    public static function validate_dates_in_order($model, $key1, $key2) {
      $message = 'Time flows in one direction. Check the order of dates.';
      if (!Validator::is_date1_before_date2($model->$key1, $model->$key2)) {
        $model->validation_errors[$key1] = $message;
        $model->validation_errors[$key2] = $message;
      }
    }
	
	
    public static function validate_not_empty($model, $key, $err_label=null) {
        $pattern = "/.+/";
        $message = "Field can not be empty.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    public static function validate_sentence($model, $key, $err_label=null) {
        $pattern = "/\d{1,2}/";
        $message = "Between 1 and 99.";
        Validator::validate($model, $key, $pattern, $message, $err_label);
    }

    public static function validate_no_inmate_with_id($model, $key, $err_label=null) {
        $message = "Credentials match an existing inmate.";
        $exists = $model->inmateId_exists($model->$key);
        if ($exists) {
            $model->validation_errors[$err_label ?? $key] = $message;
        }
    }

    public static function validate_institutionId_exists($model, $key, $err_label=null) {
        $exists = Validator::instId_exists($model, $model->$key);
        if (!$exists) {
            $message = "Not a valid Institution id.";
            $model->validation_errors[$err_label ?? $key] = $message; 
        }
    }
	
    private static function instId_exists($model, $id) {
        $sql = "SELECT Id FROM institutions WHERE id=:id LIMIT 1";
        $query = $model->db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $exists = $query->fetchColumn();
        if ($exists)
            return true;
        return false;
    }

	public static function validate_visitorId_exists($model, $key, $err_label=null) {
        $exists = Validator::visitorId_exists($model, $model->$key);
        if (!$exists) {
            $message = "Not a valid Visitor id.";
            $model->validation_errors[$err_label ?? $key] = $message; 
        }
    } 
	private static function visitorId_exists($model, $id) {
        $sql = "SELECT Id FROM visitors WHERE id=:id LIMIT 1";
        $query = $model->db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $exists = $query->fetchColumn();
        if ($exists)
            return true;
        return false;
    }
	
	public static function validate_inmateId_exists($model, $key, $err_label=null) {
        $exists = Validator::inmateId_exists($model, $model->$key);
        if (!$exists) {
            $message = "Not a valid Inmate.";
            $model->validation_errors[$err_label ?? $key] = $message; 
        }
    } 
	private static function inmateId_exists($model, $id) {
        $sql = "SELECT Id FROM inmates WHERE id=:id LIMIT 1";
        $query = $model->db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $exists = $query->fetchColumn();
        if ($exists)
            return true;
        return false;
    }
	
    public static function validate_integer_between($model, $key, $min, $max) {
        $message = "Expected integer between $min and $max.";
        $result = filter_var(
            $model->$key, 
            FILTER_VALIDATE_INT, 
            array(
                'options' => array(
                    'min_range' => $min, 
                    'max_range' => $max
                )
            )
        );
        if ($result === false) {
            $model->validation_errors[$key] = $message; 
        }
    }

    public static function validate_string_length($model, $key, $min=1, $max=1000) {
        $message_short = "Input too short. Type at least $min characters.";
        $message_long = "Input too long. The limit is $max characters.";
        $len = strlen($model->$key);
        if ($len < $min) {
            $model->validation_errors[$key] = $message_short; 
        }
        else if ($len > $max) {
            $model->validation_errors[$key] = $message_long;
        }
    }

    public static function validate_required($model, $key) {
        $message = 'Required field.';
        if(empty($model->$key)) {
            $model->validation_errors[$key] = $message; 
        }
    }
}
