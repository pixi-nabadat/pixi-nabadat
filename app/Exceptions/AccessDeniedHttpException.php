<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace  App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

use Exception;
/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AccessDeniedHttpException extends HttpException
{
    /**
     * @param string|null     $message  The internal exception message
     * @param \Throwable|null $previous The previous exception
     * @param int             $code     The internal exception code
     */
    protected $message;
    // protected $previous= null;
    protected $code;
    public function __construct(?string $message = '', int $code)
    {
        $this->code = $code;
        $this->message = $message;

    }
    public function render()
    {
        return response()->json([
            'code' => $this->code,
            'status' => false,
            'message' => $this->message,
        ], 403);
    }
}
