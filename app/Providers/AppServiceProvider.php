<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Topic;
use App\Observers\TopicObserver;
use App\Models\Reply;
use App\Observers\ReplyObserver;
use App\Models\Link;
use App\Observers\LinkObserver;
use App\Models\User;
use App\Observers\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

		\API::error(function  (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException  $exception)  {
			throw new \Symfony\Component\HttpKernel\Exception\HttpException(404,  '404 Not Found');  
		});

		\API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			abort(404);
		});

		\API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
			abort(403, $exception->getMessage());
		});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 注册观察器
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        Link::observe(LinkObserver::class);
        User::observe(UserObserver::class);
    }
}
