<?php

class Usuario extends DataMapper
{
	var $table = 'usuarios';
	var $has_one = array('rol',);
	var $has_many = array('reserva', 'tarjeta','movimiento');



	var $validation = array(
        'contrasenia' => array(
            'label' => 'Password',
            'rules' => array('required', 'trim', 'min_length' => 3, 'max_length' => 40),
            'type' => 'password'
        ),
        'confirm_password' => array(
            'label' => 'Confirm Password',
            'rules' => array('required', 'matches' => 'contrasenia', 'min_length' => 3, 'max_length' => 40),
            'type' => 'password'
        ),
        'mail' => array (
            'rules' => array('unique','required')
        ),
        'nombre' => array (
            'rules' => array('required')
        ),
        'apellido' => array (
            'rules' => array('required')
        ),
        'dniUsuario' => array (
            'rules' => array('required')
        )
    );
    
    /**
     * Login
     *
     * Authenticates a user for logging in.
     *
     * @access    public
     * @return    bool
     */
    function login()
    {
        // backup username for invalid logins
        $uname = $this->mail;

        // Create a temporary user object
        $u = new Usuario();

        // Get this users stored record via their username
        $u->where('mail', $uname)->get();

        // Give this user their stored salt
        $this->salt = $u->salt;

        // Validate and get this user by their property values,
        // this will see the 'encrypt' validation run, encrypting the password with the salt
        $this->validate()->get();

        // If the username and encrypted password matched a record in the database,
        // this user object would be fully populated, complete with their ID.

        // If there was no matching record, this user would be completely cleared so their id would be empty.
        if ($this->exists())
        {
            // Login succeeded
            return TRUE;
        }
        else
        {
            // Login failed, so set a custom error message
            $this->error_message('login', 'Username or password invalid');

            // restore username for login field
            $this->username = $uname;

            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Encrypt (prep)
     *
     * Encrypts this objects password with a random salt.
     *
     * @access    private
     * @param    string
     * @return    void
     */
    static function registrar($mail,$nombre,$apellido,$pass){
        $user = new Usuario();

        $user->mail = $mail;
        $user->nombre = $nombre;
        $user->apellido = $apellido;
        $user->contrasenia = $pass;
        $user->activo = '1';

        return $user->save();
        
    }
    function _encrypt($field)
    {
        if (!empty($this->{$field}))
        {
            if (empty($this->salt))
            {
                $this->salt = md5(uniqid(rand(), true));
            }

            $this->{$field} = sha1($this->salt . $this->{$field});
        }
    }
	function __construct($id = NULL)
	{
	parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}
?>