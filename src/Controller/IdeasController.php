<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Ideas;
use Faker\Factory;

class IdeasController
{
    /**
     * @Route("/api/ideas", name="api-ideas")
     */
    public function list()
    {
        $faker = Factory::create();
        $date = \DateTime::createFromFormat('Ymd', date('Ymd'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $json_table = array();
        for ($i = 0; $i <= random_int(10, 50); $i++){
            $idea = new Ideas();
            $idea->setId($i);
            $idea->setTitle($faker->text);
            $idea->setCreatedAt(date('Y-m-d', strtotime( '+'.mt_Rand(0,180).' days')));
            $idea->setAuthor($faker->name);
            $idea->setScore(random_int(0, 50));
            $jsonContent = $serializer->serialize($idea, 'json');
            array_push($json_table,json_encode($jsonContent));
        }
        file_put_contents('results.json', $json_table);
        $strJsonFileContents = file_get_contents("results.json");
        return new Response(
            '<html><body> '.var_dump($strJsonFileContents) .'</body></html>'
        );

        
        
    }
}