<?php
namespace App\Services;

use App\Event;
use App\Media;
use App\Location;
use App\Helpers\FileHelper;
use Intervention\Image\Facades\Image;

class LocationService {

    public function create($data) {

        $location = Location::create([
            'address' => $data['address'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'location_user_id' => $data['location_user_id'],
            'user_id' => $data['user_id'],
        ]);

        $this->createImages($location->id, $data['images']);
        
        return $location;
    }

    public function find($where){
        
        $location = Location::where($where)->with('images')->first();
        
        if(!$location){
            abort(400,'Location Does not exists');
        }

        return $location;
    }


    public function update($where,$data){
        
        $location = $this->find($where);
        
        $location->update([
            'address' => $data['address'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ]);

        $this->deleteImages($location->images);

        $this->createImages($location->id, $data['images']);

        return $this->find($where);
    }

    private function deleteImages($medias){
        foreach($medias as $media){
            FileHelper::deleteFileIfNotDefault($media->path);
            $media->delete();
        }
    }

    private function createImages($location_id, $images) {

        if ($images) {

            foreach ($images as $image) {

                $path = $this->createImageFile($image);

                Media::create([
                    'path' => $path,
                    'location_id' => $location_id
                ]);
            }

        }
    }

    private function createImageFile($image){

        $img = Image::make($image);

        $result = FileHelper::getAndCreatePath($img->filename, 'locationImages');

        $extension = substr($img->mime, strpos($img->mime, '/') + 1);

        $result['name'] = $result['name'] . str_random(15) . '.' . $extension;

        $path = $result['path'] . "/" . $result['name'];

        $img->save($path, 60);

        return $path;
    }
}