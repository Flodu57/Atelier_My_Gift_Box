<?php

namespace mygiftbox\views;

class ProfileSettingsView extends View{

    public function render(){
        $header = $this->header();
        $menu = $this->menu();
        $html = "
            <html>
                $header
                <body>     
                    <div class='container'>
                        ".parent::error()."
                        $menu

                        <div class='settings'>
                            <div class='settings_password'>
                                <h1>Changer son mot de passe</h1>

                                <form method='POST'>
                                    <input placeholder='Mot de passe actuel' type='password' name='password'>
                                    <input placeholder='Nouveau mot de passe' type='password' name='new_password'>
                                    <button type='submit'>Sauvegarder</button>
                                </form>
                            </div>

                            <div class='settings_delete'>
                                <h1>Supprimer son compte</h1>

                                <form method='post'>
                                    <input placeholder='Mot de passe actuel' type='password' name='password'>
                                    <input type='hidden' name='_METHOD' value='delete'/>
                                    <button type='submit'>Supprimer</button>
                                </form>
                            </div>

                            
                        </div>

                       
                    </div>
                </body>
            </html>  
        ";
        echo $html;
    }

}