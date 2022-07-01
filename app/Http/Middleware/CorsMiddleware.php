<?php
namespace App\Http\Middleware;
//C:\xampp\php\ext\php_memcached.dll
//C:\xampp\php\ext\php_memcached.dll
use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $allowedOrigins = ['http://localhost:3000', 'http://localhost:3030', 'http://localhost:3060', 'example.com'];
//        $origin = request()->headers->get('origin');
//
//        $isThere = in_array($origin, $allowedOrigins) === true ? '*' : '';

        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With,Origin'
        ];


//        if($request->server('HTTP_ORIGIN')){
//            if (in_array($request->server('HTTP_ORIGIN'), $allowedOrigins)) {
//                $headers += ['Access-Control-Allow-Origin' => $request->server('HTTP_ORIGIN')];
//            }
//        }

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);

        if ($response instanceof BinaryFileResponse) {
            foreach($headers as $key => $value)
                $response->headers->set($key, $value);
            return $response;
        }

        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }
        return $response;
    }
}
