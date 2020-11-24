<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserService{

    public function addUser(Request $request, SerializerInterface $serialize,UserPasswordEncoderInterface $encoder,EntityManagerInterface $entity)
    {
         
        $User_json = $request->request->all();
        $image = $request->files->get("avatar");
        $User = $serialize ->denormalize($User_json,"App\Entity\User",true);
        $image = fopen($image->getRealPath(),"rb");
        $User -> setAvatar($image);
        $User ->setArchived(0);
        $password = $User -> getPassword();
        $User -> SetPassword($encoder->encodePassword($User, $password));
        $entity -> persist($User);
        $entity -> flush();
        fclose($image);
        return $this->json("succes",201);

        
    }
}