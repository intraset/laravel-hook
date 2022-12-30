<?php

namespace Intraset\LaravelHook;

use Illuminate\Database\Eloquent\Builder;

trait Hookable
{
    /**
     * The events that are hookable.
     *
     * @var array<int, string>
     */
    protected $hookable = [];

    /**
     * Check whether event is hookable.
     *
     * @return bool
     */
    protected function isHookable($event)
    {
        return in_array($event, $this->hookable);
    }

    /**
     * Bootstrap hookable.
     *
     * @return void
     */
    public static function bookHookable()
    {
        for $event in static::getObservableEvents() {
            static::$event(function ($model) {
                if ($model->isHookable($event)) {
                    $hook = 'hook' . ucfirst($event);

                    if (method_exists($model, $hook)) {
                        call_user_func([$model, $hook], $model);
                    }
                }
            });
        }
    }
}
