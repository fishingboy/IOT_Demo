<?php

class Status_error_code
{
    public static $variableError = 400101;
    public static $articleError = 400105;
    public static $replyError = 400106;
    public static $tokenError = 400401;
    public static $authFailError = 400402;
    public static $permissionError = 400403;
    public static $notFoundError = 400404;
    public static $bucketAuthError = 400405;
    public static $chatAreaPasswordError = 400201;
    public static $chatAreaNotFoundError = 400202;
    public static $iconSettingError = 400501;
    public static $sendBirdApiError = 400999;
    public static $dbInsertError = 500101;
    public static $idDuplicateError = 500102;
    public static $writeFileError = 500103;
    public static $dbUpdateError = 500104;
    public static $socketBindUsrError = 500201;
    public static $socketBindGrpError = 500202;

    /**
     * HttpErrorCode constructor.
     */
    public function __construct()
    {
        $this->messageTable = $this->getDefaultErrorMsg();
    }

    private function getDefaultErrorMsg()
    {
        return [
            self::$tokenError            => 'api token error or expired',
            self::$variableError         => 'variableError',
            self::$authFailError         => 'auth failed error',
            self::$permissionError       => 'permission error',
            self::$notFoundError         => 'data not found',
            self::$dbInsertError         => 'database insert Error',
            self::$dbUpdateError         => 'database update Error',
            self::$chatAreaPasswordError => 'shrimp area password error',
            self::$chatAreaNotFoundError => 'shrimp area not found',
            self::$sendBirdApiError      => 'unknown sendBird Api error',
            self::$idDuplicateError      => 'unique id duplicate error',
            self::$writeFileError        => 'write file error',
            self::$articleError          => 'article error',
            self::$replyError            => 'reply error',
            self::$socketBindUsrError    => 'bind user error',
            self::$socketBindGrpError    => 'bind group error',
            self::$bucketAuthError       => 'user is bucketed',
            self::$iconSettingError      => 'icon setting error',
        ];
    }

    public function getErrorMsg($code, $message = '')
    {
        if ($message == '') {
            $message = $this->messageTable[$code];
        };

        return (object)[
            'code' => $code,
            'message' => $message,
            'error' => true
        ];
    }
}
