<?php

/* 
 * Flash Messages
 */

class FlashMessages {
   
    public function message($name = '', $message = '', $class = 'success')
    {
        //We can only do something if the name isn't empty
        if( !empty( $name ) )
        {
            //No message, create it
            if( !empty( $message ) && empty( $_SESSION[$name] ) )
            {
                if( !empty( $_SESSION[$name] ) )
                {
                    unset( $_SESSION[$name] );
                }
                if( !empty( $_SESSION[$name.'_class'] ) )
                {
                    unset( $_SESSION[$name.'_class'] );
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name.'_class'] = $class;
            }
            //Message exists, display it
            elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
            {
                $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
                $html = sprintf('<div class="alert alert-%s" role="alert">%s</div>', $class, $_SESSION[$name]);
                unset($_SESSION[$name]);
                unset($_SESSION[$name.'_class']);
                return $html;
            }
        }
    }
    
}
