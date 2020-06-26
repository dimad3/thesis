<?php
// L#11
class Redirect
{
// Redirect to another page and display the contents of that page.
// Parameters: string   Required. The URL you wish the users to be redirected too
// Returvs - No value is returned.
public static function to($location = null)
{
    // check whether `$location variable` is set, which means that it is declared and is not NULL
    if($location) {
        /* The header() function sends a raw HTTP header to a client.
        Basically, HTTP functions allow you to manipulate information sent to the browser 
        by the webserver before any other output has been sent.
        It must be called before sending any actual output, either by normal HTML tags, 
        blank lines in a file or from a PHP file.
        Parameter Values:
        1) header	Required. This parameter hold the header string. There are two types of header calls. 
        The first header starts with string “HTTP/”, which is used to figure out 
        the HTTP status code to send. The second case of header is the “Location:”.
        2) replace	Optional. Indicates whether the header should replace a previous 
        similar header or add a new header of the same type.
        Default is TRUE (will replace). FALSE allows multiple headers of the same type
        3) http_response_code	Optional. Forces the HTTP response code to the specified value
        Return Value:	Nothing
        */
        if(is_numeric($location)) {
            switch ($location) {
                case 404:
                    // https://stackoverflow.com/questions/16254291/php-404-not-found-header
                    header('HTTP/1.0 404 Not Found.'); // is only giving notice that user is on 404 error page
                    
                    // if you want to display some 404 notice for user you can do this 
                    // by loading your 404.html file
                    include_once __DIR__ . '/../includes/errors/404.php';
                    
                    /* exit function is there because you have to prevent execution of 
                    another php code, which may be directly after it or which 
                    may be excecuted later, simply it says END */
                    exit;
                // Use break to prevent the code from running into the next case automatically
                // break ends execution of the current for, foreach, while, do-while or switch structure.
                break;
            }
        }
        // Redirect to another page with URL provided in `$location variable`
        header('Location:' . $location);
    }
}

}
