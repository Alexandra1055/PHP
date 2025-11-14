<?php
class User{

}
class Newsletter{
    public function subscribe(User $user, NewsletterProvider $provider){

        $provider->addToList('default', $user->email);
        //Actualiza el usuario y lo marca como suscrito
        $user->update(['suscribed' => true]);

        return true;
    }
}

interface NewsletterProvider{
    public function addToList(string $list, string $email):void;
}

class CampaingMonitor implements NewsletterProvider {
    public function addToList(string $list, string $email):void{
        //interactua con el monitor de camapaña
        $cm = new CampaingMonitorAPI();
        $cm->addApiKey('abc');
        $list = $cm -> lists -> find($list);
        $list->addToList($email);
    }
}

class PostmarkProvider implements NewsletterProvider {
    public function addToList(string $list, string $email):void{
        //interactua con el monitor de camapaña
        $cm = new PostmarkAPI('defg');
        $list = $cm->addToDefaultList($email);
    }
}

$newsletter = new Newsletter();
$newsletter->subscribe(new User());