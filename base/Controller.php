<?php namespace base;

abstract class Controller
{
    /**
     * @param string $name is the path of a viewfile inside "views" folder without
     * an extension. For example: "users/list" for a viewfile "views/users/list.php".
     * @param array $variables is an associative array where keys are the names of
     * variables that will be accessible in the viewfile and values are their values.
     */
    protected function renderViewfile(string $name, array $variables = [])
    {
        $file = "views/$name.php";
        if (!file_exists($file)) echo "Error: viewfile $name does not exist";
        
        foreach ($variables as $name => $value) {
            // These local variables will be accessible in $file.
            $$name = $value;
        }
        
        require $file;
    }

    protected function saveErrorsAndGoBack(string $cookieName, array $errors)
    {
        (new FlashCookies($cookieName))->saveData($errors);
        (new Router)->goBack();
    }

    protected function loadErrors(string $cookieName): array
    {
        return (new FlashCookies($cookieName))->getData();
    }
}