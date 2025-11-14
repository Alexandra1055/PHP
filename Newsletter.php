<?php
class User{

}
class Newsletter{
    public function subscribe(User $user){
        //interactua con el monitor
        $cm = new CampaingMonitor();
        $cm->addApiKey('abc');
        $list = $cm -> lists -> find('default');
        $list->addToList($user->email);

        //Actualiza el usuario y lo marca como suscrito
        $user->update(['suscribed' => true]);

        return true;
    }
}

$newsletter = new Newsletter();
$newsletter->subscribe(new User());