<?php
$config = array(
                 'user' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'E-mail',
                                            'rules' => 'required|is_unique[users.email]|valid_email'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Hasło',
                                            'rules' => 'required|matches[cnfpassword]|min_length[6]'
                                         ),
									array(
                                            'field' => 'cnfpassword',
                                            'label' => 'Powtórz hasło',
                                            'rules' => 'required'
                                         ),
									array(
                                            'field' => 'first_name',
                                            'label' => 'Imię',
                                            'rules' => ''
                                         ),
									array(
                                            'field' => 'second_name',
                                            'label' => 'nazwisko',
                                            'rules' => ''
                                         )
                                ),
				 'userEdit' => array(                                 
                                    array(
                                            'field' => 'password',
                                            'label' => 'Hasło',
                                            'rules' => 'matches[cnfpassword]|min_length[6]'
                                         ),
									array(
                                            'field' => 'cnfpassword',
                                            'label' => 'Powtórz hasło',
                                            'rules' => 'matches[password]|min_length[6]'
                                         ),
									array(
                                            'field' => 'first_name',
                                            'label' => 'Imię',
                                            'rules' => ''
                                         ),
									array(
                                            'field' => 'second_name',
                                            'label' => 'nazwisko',
                                            'rules' => ''
                                         )
                                ),
				'changePassword' => array(                                 
										array(
												'field' => 'password',
												'label' => 'Hasło',
												'rules' => 'required|matches[cnfpassword]|min_length[6]'
											 ),
										array(
												'field' => 'cnfpassword',
												'label' => 'Powtórz hasło',
												'rules' => 'required|matches[password]|min_length[6]'
											 )
									),
			   'userGroup' => array(
                                    array(
                                            'field' => 'name',
                                            'label' => 'Nazwa',
                                            'rules' => 'required'
                                         )
									),
				'element' => array(
                                    array(
                                            'field' => 'name',
                                            'label' => 'Nazwa',
                                            'rules' => 'required'
                                         )
									),
				'paint' => array(
                                    array(
                                            'field' => 'name',
                                            'label' => 'Nazwa',
                                            'rules' => 'required'
                                         )
									),
				'customer' => array(
                                    array(
                                            'field' => 'name',
                                            'label' => 'Nazwa',
                                            'rules' => 'required'
                                         ),
									array(
                                            'field' => 'post_code',
                                            'label' => 'Kod pocztowy',
                                            'rules' => 'required'
                                         ),
									array(
                                            'field' => 'street',
                                            'label' => 'Ulica',
                                            'rules' => 'required'
                                         ),
									array(
                                            'field' => 'city',
                                            'label' => 'Miejscowość',
                                            'rules' => 'required'
                                         ),
									
									array(
                                            'field' => 'email',
                                            'label' => 'E-mail',
                                            'rules' => 'valid_email'
                                         )
									)
								
				
               );
		
?>