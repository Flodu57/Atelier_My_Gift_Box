<?php

namespace mygiftbox\views;


class VisitorCagnotteView extends View{

    private $box;

    public function __construct($box){
        parent::__construct();
        $this->box = $box;
    }

    public function render(){

        

        $pres = "";

END;
        }

        $html = <<<END
            <html>
                $this->header
                <body>     
                    <div class='container'>
                        $this->menu
                        $error
                        
                        $this->footer
                    </div>
                </body>
            </html>  
END;
        echo $html;
    }


}