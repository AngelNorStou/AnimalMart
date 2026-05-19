<?php
/**
 * UserView - Secure version
 * Prevents XSS by escaping output
 * Uses strict typing and null safety
 */

class UserView
{
    private UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }


    /**
     * Display a user field safely (escaped for HTML)
     */
    public function displayField(string $username, string $field): string
    {
        $value = $this->userModel->getUserByUsername($username, $field);

        if ($value === null || $value === '') {
            return 'N/A';
        }

        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }


    /**
     * Display user profile picture safely
     */
    public function displayPicture(string $username, int $width = 150, int $height = 150): string
    {
        $user = $this->userModel->getUserByUsernameComplete($username); // Changed this
        $src = empty($user['profile_picture'])
            ? "../uploads/profile_pictures/default.png"
            : "../" . htmlspecialchars($user['profile_picture'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        return sprintf(
            '<img src="%s" width="%d" height="%d" class="img-thumbnail" alt="User Profile Picture">',
            $src,
            $width,
            $height
        );
    }

    private function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Return picture source for <img>
     */
    public function displayPictureSource(string $username): string
    {
        $user = $this->userModel->getUserByUsernameComplete($username);
        if (!$user || empty($user['profile_picture'])) {
            return '../Images/guest.jpg';
        }

        return $this->e('../' . $user['profile_picture']);
    }

    /**
     * Display a user field safely (alias for backward compat)
     */
    public function displayItem(string $username, string $field): string
    {
        return $this->displayField($username, $field);
    }
}
