<?php
namespace App\Services;

use App\BlackList;


class BlackListService {

    
    public function all(){
        $qb = $this->getQB();
        return $qb->get();
    }

    public function allWithPagination(){
        $qb = $this->getQB();
        return $qb->paginate();
    }

    public function find($id){
        
        $blackList = BlackList::find($id);
        
        if(!$blackList){
            abort(400,'Black List Does not exists');
        }

        return $blackList;
    }

    public function create($data){
        return BlackList::create($this->getSecureInput($data));
    }

    public function update($id,$data){
        
        $blackList = $this->find($id);
        
        $blackList->update($this->getSecureInput($data));

        return $blackList;
    }

    public function delete($id){
       return  BlackList::where('id',$id)->delete();
    }


    private function getQB(){
        $qb = BlackList::orderBy('updated_at','DESC');
        return $qb;
    }

    private function getSecureInput($data){
        return [
            'country_code' => $data['country_code'],
            'country' => $data['country'],
            'all_features' => $data['all_features'],
            'features' => json_encode($data['features']),
        ];
    }

}