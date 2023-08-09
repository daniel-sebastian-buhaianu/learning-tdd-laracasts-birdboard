<?php

namespace App;
use App\Models\Activity;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public $previousAttributes = [];

    public static function bootRecordsActivity()
    {
        foreach (self::recordableActivities() as $activity) {
            static::$activity(function ($model) use ($activity) {
                $model->recordActivity($model->activityDescription($activity));
            });

            if ($activity === 'updated') {
                static::updating(function ($model) {
                    $model->previousAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription(string $activity)
    {
        return strtolower(class_basename($this)) . '_' . $activity;
    }

    public function recordActivity(string $description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->previousAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    protected static function recordableActivities()
    {
        if (isset(static::$recordableActivities)) {
            return static::$recordableActivities;
        }
        
        return ['created', 'updated', 'deleted'];
    }
}