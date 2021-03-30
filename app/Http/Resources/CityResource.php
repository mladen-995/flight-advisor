<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country,
            'description' => $this->description,
            'comments' => $this->comments(),
        ];
    }

    private function comments()
    {
        if (request()->exists('number_of_latest_comments')) {
            return $this->getLatestNthComments(request()->input('number_of_latest_comments'));
        }

        return $this->comments;
    }
}
