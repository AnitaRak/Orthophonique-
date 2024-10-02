<?php
namespace App\Service;

class JWTService{
    //On génere le token

   
   
    //On va gerer la validité du mail en utilisant le jwt,10800 seconde = 3h 
    public function generate(array $header,array $payload, string $secret,int $validity = 10800):string{
        
        
        if($validity > 0){
        
            //Je recupere le temps actuelle
            $now = new \DateTimeImmutable;
            //date d'expiration, je recupere le timestamp et je lui ajoute la validité
            $exp = $now->getTimestamp() + $validity;

            $payload['iat'] = $now ->getTimestamp();
            $payload['exp'] = $exp;

        }

        
       //On encode le tout en base64, Mon Header,payload sera encoder en JSON puis convertie en base64
       $base64Header = base64_encode(json_encode($header));
       $base64Payload = base64_encode(json_encode($payload));

       //On nettoie les valeurs encodés (retrait des +,/ et =)
       $base64Header = str_replace(['+','/','='],['-','_',''], $base64Header);
       $base64Payload= str_replace(['+','/','='],['-','_',''], $base64Payload);

       //on genere la signature
       $secret = base64_encode($secret);

       $signature = hash_hmac('sha256',$base64Header . '.' . $base64Payload,$secret, true);

       $base64Signature = base64_encode($signature);
       $base64Signature = str_replace(['+','/','='],['-','_',''], $base64Signature);

       //On creer le token
        $jwt = $base64Header. '.' . $base64Payload . '.' . $base64Signature;
        return $jwt;
    }

    //On verifie que le token est valide (correctement formé)
    public function isValid(string $token):bool{
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',$token
        ) ==1;
    }

     //On récupere le Header 
     public function getHeader(string $token):array{

        //On démonte le token
        $array = explode('.',$token);

        //On decode le header
        $header = json_decode(base64_decode($array[0]),true);
        return $header;

    }

    //On récupere le payload qui nous permettre de savoir si le token est expirer
    public function getPayload(string $token):array{

        //On démonte le token
        $array = explode('.',$token);

        //On decode le payload
        $payload = json_decode(base64_decode($array[1]),true);
        return $payload;

    }

    //On verifie si le token à expirer
    public function isExpired(string $token):bool{
        $payload = $this->getPayload($token);

        $now = new \DateTimeImmutable;

        //le token sera considéré comme expiré ,Si l'expiration est plus petite que maintenant 
        return $payload['exp'] < $now->getTimestamp();
    }

    //On verifie la signature du token
    public function check(string $token, string $secret){
        
        //On recupere le header et le payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        //On regenere un token
        $verifToken = $this->generate($header,$payload, $secret,0);

        return $token === $verifToken;

    }
}