<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Client;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadTags($manager);
        $this->loadPosts($manager);
    }


    private  function setTbaGroup($manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $tbaClient= new Client();
        $tbaClient->setName('tba');
        $tbaClient->setCompanyName('tba');
        $tbaClient->setCity('tba');
        $tbaClient->setAddress('tba');
        $tbaClient->setContactPersonEmail('tba@gmail.com');
        $tbaClient->setContactPersonPhone('111');
        $tbaClient->setContactPersonName('tba');
        $tbaClient->setState('Valencia');
        $tbaClient->setCountry('ES');
        $tbaClient->setPostalCode('000');
        $tbaClient->setTaxId('000');
        $manager->persist($tbaClient);

        $adminTBA = new User();
        $adminTBA->setFullName('EL SUPER ADMIN');
        $adminTBA->setUsername('tba');
        $adminTBA->setEmail('tba@gmail.com');
        $adminTBA->setPassword($passwordEncoder->encodePassword($adminTBA, 'tba'));
        $adminTBA->setEnabled(true);
        $adminTBA->setSuperAdminSupreme(true);
        $adminTBA->setRoles(['ROLE_SUPER_ADMIN']);
        $adminTBA->setClient($tbaClient);
        $manager->persist($adminTBA);
        $this->addReference('tba', $adminTBA);

    }


    private  function setOscarGroup($manager,$passwordEncoder)
    {
        $oscarClient = new Client();
        $oscarClient->setName('oscar');
        $oscarClient->setCompanyName('zinkers');
        $oscarClient->setCity('pedreger');
        $oscarClient->setAddress('12');
        $oscarClient->setContactPersonEmail('oscar@outlook.es');
        $oscarClient->setContactPersonPhone('111');
        $oscarClient->setContactPersonName('oscar');
        $oscarClient->setState('Valencia');
        $oscarClient->setCountry('ES');
        $oscarClient->setPostalCode('000');
        $oscarClient->setTaxId('000');
        $manager->persist($oscarClient);

        $adminFinca = new User();
        $adminFinca->setFullName('Oscar Carrio');
        $adminFinca->setUsername('oscar');
        $adminFinca->setEmail('oscar@gmail.com');
        $adminFinca->setPassword($passwordEncoder->encodePassword($adminFinca, 'oscar'));
        $adminFinca->setEnabled(true);
        $adminFinca->setRoles(['ROLE_ADMIN']);
        $adminFinca->setClient($oscarClient);
        $manager->persist($adminFinca);

        $userBasic  = new User();
        $userBasic->setFullName('EMPLEADO 1 OSCAR');
        $userBasic->setUsername('emposcar');
        $userBasic->setEmail('emposcar@gmail.com');
        $userBasic->setPassword($passwordEncoder->encodePassword($adminFinca, 'oscar'));
        $userBasic->setEnabled(true);
        $userBasic->setRoles(['ROLE_USER']);
        $userBasic->setClient($oscarClient);
        $manager->persist($userBasic);
        $this->addReference('emposcar', $userBasic);

    }


    private  function setRubenGroup($manager,$passwordEncoder)
    {
        $rubenClient = new Client();
        $rubenClient->setName('ruben');
        $rubenClient->setCompanyName('google');
        $rubenClient->setCity('benidorm');
        $rubenClient->setAddress('12');
        $rubenClient->setContactPersonEmail('ruben_m7@outlook.es');
        $rubenClient->setContactPersonPhone('111');
        $rubenClient->setContactPersonName('ruben');
        $rubenClient->setState('Valencia');
        $rubenClient->setCountry('ES');
        $rubenClient->setPostalCode('000');
        $rubenClient->setTaxId('000');
        $manager->persist($rubenClient);

        $adminFinca = new User();
        $adminFinca->setFullName('Ruben Molines');
        $adminFinca->setUsername('ruben');
        $adminFinca->setEmail('ruben@gmail.com');
        $adminFinca->setPassword($passwordEncoder->encodePassword($adminFinca, 'ruben'));
        $adminFinca->setEnabled(true);
        $adminFinca->setRoles(['ROLE_ADMIN']);
        $adminFinca->setClient($rubenClient);
        $manager->persist($adminFinca);

        $userBasic = new User();
        $userBasic->setFullName('empleado Ruben Molines');
        $userBasic->setUsername('empruben');
        $userBasic->setEmail('empruben@gmail.com');
        $userBasic->setPassword($passwordEncoder->encodePassword($adminFinca, 'ruben'));
        $userBasic->setEnabled(true);
        $userBasic->setRoles(['ROLE_USER']);
        $userBasic->setClient($rubenClient);
        $manager->persist($userBasic);
        $this->addReference('empruben', $userBasic);

    }



    private function loadUsers(ObjectManager $manager): void
    {
        $this->setTbaGroup($manager, $this->passwordEncoder);
        $this->setRubenGroup($manager, $this->passwordEncoder);
        $this->setOscarGroup($manager, $this->passwordEncoder);

        $manager->flush();
    }

    private function loadTags(ObjectManager $manager): void
    {
        foreach ($this->getTagData() as $index => $name) {
            $tag = new Tag();
            $tag->setName($name);

            $manager->persist($tag);
            $this->addReference('tag-'.$name, $tag);
        }

        $manager->flush();
    }

    private function loadPosts(ObjectManager $manager): void
    {
        foreach ($this->getPostData() as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $post = new Post();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            $post->addTag(...$tags);

            foreach (range(1, 5) as $i) {
                $comment = new Comment();
                $comment->setAuthor($this->getReference('tba'));
                $comment->setContent($this->getRandomText(random_int(255, 512)));
                $comment->setPublishedAt(new \DateTime('now + '.$i.'seconds'));

                $post->addComment($comment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['Jane Doe', 'jane_admin', 'kitten', 'jane_admin@symfony.com', ['ROLE_USER'], true, false],
            ['Tom Doe', 'tom_admin', 'kitten', 'tom_admin@symfony.com', ['ROLE_ADMIN'], true, false],
            ['John Doe', 'john_user', 'kitten', 'john_user@symfony.com', ['ROLE_SUPER_ADMIN'], true, false],
        ];
    }

    private function getTagData(): array
    {
        return [
            'lorem',
            'ipsum',
            'consectetur',
            'adipiscing',
            'incididunt',
            'labore',
            'voluptate',
            'dolore',
            'pariatur',
        ];
    }

    private function getPostData()
    {
        $posts = [];
        foreach ($this->getPhrases() as $i => $title) {
            // $postData = [$title, $slug, $summary, $content, $publishedAt, $author, $tags, $comments];
            $posts[] = [
                $title,
                Slugger::slugify($title),
                $this->getRandomText(),
                $this->getPostContent(),
                new \DateTime('now - '.$i.'days'),
                // Ensure that the first post is written by Jane Doe to simplify tests
                $this->getReference(['tba', 'empruben'][0 === $i ? 0 : random_int(0, 1)]),
                $this->getRandomTags(),
            ];
        }

        return $posts;
    }

    private function getPhrases(): array
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }

    private function getRandomText(int $maxLength = 255): string
    {
        $phrases = $this->getPhrases();
        shuffle($phrases);

        while (mb_strlen($text = implode('. ', $phrases).'.') > $maxLength) {
            array_pop($phrases);
        }

        return $text;
    }

    private function getPostContent(): string
    {
        return <<<'MARKDOWN'
Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
incididunt ut labore et **dolore magna aliqua**: Duis aute irure dolor in
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
deserunt mollit anim id est laborum.

  * Ut enim ad minim veniam
  * Quis nostrud exercitation *ullamco laboris*
  * Nisi ut aliquip ex ea commodo consequat

Praesent id fermentum lorem. Ut est lorem, fringilla at accumsan nec, euismod at
nunc. Aenean mattis sollicitudin mattis. Nullam pulvinar vestibulum bibendum.
Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos
himenaeos. Fusce nulla purus, gravida ac interdum ut, blandit eget ex. Duis a
luctus dolor.

Integer auctor massa maximus nulla scelerisque accumsan. *Aliquam ac malesuada*
ex. Pellentesque tortor magna, vulputate eu vulputate ut, venenatis ac lectus.
Praesent ut lacinia sem. Mauris a lectus eget felis mollis feugiat. Quisque
efficitur, mi ut semper pulvinar, urna urna blandit massa, eget tincidunt augue
nulla vitae est.

Ut posuere aliquet tincidunt. Aliquam erat volutpat. **Class aptent taciti**
sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi
arcu orci, gravida eget aliquam eu, suscipit et ante. Morbi vulputate metus vel
ipsum finibus, ut dapibus massa feugiat. Vestibulum vel lobortis libero. Sed
tincidunt tellus et viverra scelerisque. Pellentesque tincidunt cursus felis.
Sed in egestas erat.

Aliquam pulvinar interdum massa, vel ullamcorper ante consectetur eu. Vestibulum
lacinia ac enim vel placerat. Integer pulvinar magna nec dui malesuada, nec
congue nisl dictum. Donec mollis nisl tortor, at congue erat consequat a. Nam
tempus elit porta, blandit elit vel, viverra lorem. Sed sit amet tellus
tincidunt, faucibus nisl in, aliquet libero.
MARKDOWN;
    }

    private function getRandomTags(): array
    {
        $tagNames = $this->getTagData();
        shuffle($tagNames);
        $selectedTags = \array_slice($tagNames, 0, random_int(2, 4));

        return array_map(function ($tagName) { return $this->getReference('tag-'.$tagName); }, $selectedTags);
    }
}
