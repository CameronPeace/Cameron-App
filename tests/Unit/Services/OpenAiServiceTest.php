<?php

namespace Tests\Unit\Services;

use App\Services\OpenAiService;
use PHPUnit\Framework\TestCase;

class OpenAiServiceTest extends TestCase
{

    /**
     * Test the requestTheaterData function returns expected data.
     *
     * @return void
     */
    public function testRequestTheaterData()
    {
        $return = $this->buildTheaterData();

        $mock = $this->getMockBuilder('App\Services\Helpers\OpenAiRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('sendChatPrompt')->willReturn($return);

        $service = new OpenAiService($mock);

        $theaters = $service->requestTheaterData(10);

        $this->assertNotEmpty($theaters);
        $this->assertEqualsCanonicalizing($return['body']['choices'][0]['message']['content'], $theaters);
    }

    /**
     * Test the  requestMovieData can parse and return the correct response.
     *
     * @return void
     */
    public function testRequestMovieData()
    {
        $return = $this->buildMovieData();

        $mock = $this->getMockBuilder('App\Services\Helpers\OpenAiRequest')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('sendChatPrompt')->willReturn($return);

        $service = new OpenAiService($mock);

        $movies = $service->requestMovieData(10);

        $this->assertNotEmpty($movies);
        $this->assertEqualsCanonicalizing($return['body']['choices'][0]['message']['content'], $movies);
    }

    /**
     * Return a typical ChatGPT response containing theater data.
     *
     * @return array
     */
    private function buildTheaterData()
    {
       return array (
            'body' =>
            array (
              'id' => 'chatcmpl-AYfte42xeSH0bDKpzSARqxRMnMYcy',
              'object' => 'chat.completion',
              'created' => 1732827566,
              'model' => 'gpt-4o-mini-2024-07-18',
              'choices' =>
              array (
                0 =>
                array (
                  'index' => 0,
                  'message' =>
                  array (
                    'role' => 'assistant',
                    'content' => '[
              {
                  "location_name": "AMC Empire 25",
                  "city": "New York",
                  "state": "NY",
                  "street": "234 W 42nd St",
                  "zip5": "10036"
              },
              {
                  "location_name": "Regal LA Live & 4DX",
                  "city": "Los Angeles",
                  "state": "CA",
                  "street": "1000 W Olympic Blvd",
                  "zip5": "90015"
              },
              {
                  "location_name": "Cinemark 17",
                  "city": "Tampa",
                  "state": "FL",
                  "street": "5555 W Waters Ave",
                  "zip5": "33634"
              },
              {
                  "location_name": "Alamo Drafthouse Cinema",
                  "city": "Austin",
                  "state": "TX",
                  "street": "320 E 6th St",
                  "zip5": "78701"
              },
              {
                  "location_name": "Regal Edwards Grand Palace",
                  "city": "Los Angeles",
                  "state": "CA",
                  "street": "1000 W 7th St",
                  "zip5": "90017"
              },
              {
                  "location_name": "Cinemark Movies 14",
                  "city": "San Jose",
                  "state": "CA",
                  "street": "1500 S 1st St",
                  "zip5": "95110"
              },
              {
                  "location_name": "AMC The Grove 14",
                  "city": "Los Angeles",
                  "state": "CA",
                  "street": "189 The Grove Dr",
                  "zip5": "90036"
              },
              {
                  "location_name": "Regal Cinemas",
                  "city": "Chicago",
                  "state": "IL",
                  "street": "100 W 62nd St",
                  "zip5": "60629"
              },
              {
                  "location_name": "Cinemark 20",
                  "city": "Woodbridge",
                  "state": "VA",
                  "street": "14900 Potomac Town Pl",
                  "zip5": "22191"
              },
              {
                  "location_name": "Alamo Drafthouse Cinema",
                  "city": "Denver",
                  "state": "CO",
                  "street": "4255 W Colfax Ave",
                  "zip5": "80204"
              },
              {
                  "location_name": "AMC River East 21",
                  "city": "Chicago",
                  "state": "IL",
                  "street": "322 E Illinois St",
                  "zip5": "60611"
              },
              {
                  "location_name": "Regal Cinemas",
                  "city": "Orlando",
                  "state": "FL",
                  "street": "4000 Conroy Rd",
                  "zip5": "32839"
              },
              {
                  "location_name": "Cinemark 16",
                  "city": "Cleveland",
                  "state": "OH",
                  "street": "5250 Richmond Rd",
                  "zip5": "44146"
              },
              {
                  "location_name": "AMC Theatres",
                  "city": "Seattle",
                  "state": "WA",
                  "street": "2000 6th Ave",
                  "zip5": "98109"
              },
              {
                  "location_name": "Regal Cinemas",
                  "city": "Phoenix",
                  "state": "AZ",
                  "street": "5000 S Arizona Mills Cir",
                  "zip5": "85282"
              },
              {
                  "location_name": "Cinemark 18",
                  "city": "Fort Worth",
                  "state": "TX",
                  "street": "4800 S Hulen St",
                  "zip5": "76132"
              }
          ]',
                    'refusal' => NULL,
                  ),
                  'logprobs' => NULL,
                  'finish_reason' => 'stop',
                ),
              ),
              'usage' =>
              array (
                'prompt_tokens' => 77,
                'completion_tokens' => 821,
                'total_tokens' => 898,
                'prompt_tokens_details' =>
                array (
                  'cached_tokens' => 0,
                  'audio_tokens' => 0,
                ),
                'completion_tokens_details' =>
                array (
                  'reasoning_tokens' => 0,
                  'audio_tokens' => 0,
                  'accepted_prediction_tokens' => 0,
                  'rejected_prediction_tokens' => 0,
                ),
              ),
              'system_fingerprint' => 'fp_0705bf87c0',
            ),
            'status' => 200,
        );
    }

    /**
     * Return a typical ChatGPT response containing movie data.
     *
     * @return array
     */
    private function buildMovieData()
    {
        return array (
            'body' =>
            array (
              'id' => 'chatcmpl-AYftoAv6FOBFcAxquzH2pbP826pmr',
              'object' => 'chat.completion',
              'created' => 1732827576,
              'model' => 'gpt-4o-mini-2024-07-18',
              'choices' =>
              array (
                0 =>
                array (
                  'index' => 0,
                  'message' =>
                  array (
                    'role' => 'assistant',
                    'content' => '[
              {
                  "title": "The Lion King",
                  "genre": "Animation",
                  "director": "Roger Allers, Rob Minkoff",
                  "release_date": "1994-06-15"
              },
              {
                  "title": "Toy Story",
                  "genre": "Animation",
                  "director": "John Lasseter",
                  "release_date": "1995-11-22"
              },
              {
                  "title": "Finding Nemo",
                  "genre": "Animation",
                  "director": "Andrew Stanton",
                  "release_date": "2003-05-30"
              },
              {
                  "title": "Frozen",
                  "genre": "Animation",
                  "director": "Chris Buck, Jennifer Lee",
                  "release_date": "2013-11-27"
              },
              {
                  "title": "The Incredibles",
                  "genre": "Animation",
                  "director": "Brad Bird",
                  "release_date": "2004-11-05"
              },
              {
                  "title": "Zootopia",
                  "genre": "Animation",
                  "director": "Byron Howard, Rich Moore",
                  "release_date": "2016-03-17"
              },
              {
                  "title": "Shrek",
                  "genre": "Animation",
                  "director": "Andrew Adamson, Vicky Jenson",
                  "release_date": "2001-05-22"
              },
              {
                  "title": "Coco",
                  "genre": "Animation",
                  "director": "Lee Unkrich, Adrian Molina",
                  "release_date": "2017-11-22"
              },
              {
                  "title": "Inside Out",
                  "genre": "Animation",
                  "director": "Pete Docter, Ronnie del Carmen",
                  "release_date": "2015-06-19"
              },
              {
                  "title": "Up",
                  "genre": "Animation",
                  "director": "Pete Docter, Bob Peterson",
                  "release_date": "2009-05-29"
              },
              {
                  "title": "Kung Fu Panda",
                  "genre": "Animation",
                  "director": "Mark Osborne, John Stevenson",
                  "release_date": "2008-06-06"
              },
              {
                  "title": "Despicable Me",
                  "genre": "Animation",
                  "director": "Pierre Coffin, Chris Renaud",
                  "release_date": "2010-07-09"
              },
              {
                  "title": "Monsters, Inc.",
                  "genre": "Animation",
                  "director": "Pete Docter, David Silverman",
                  "release_date": "2001-11-02"
              },
              {
                  "title": "Ratatouille",
                  "genre": "Animation",
                  "director": "Brad Bird, Jan Pinkava",
                  "release_date": "2007-06-29"
              },
              {
                  "title": "WALL-E",
                  "genre": "Animation",
                  "director": "Andrew Stanton",
                  "release_date": "2008-06-27"
              },
              {
                  "title": "The Secret Life of Pets",
                  "genre": "Animation",
                  "director": "Chris Renaud",
                  "release_date": "2016-07-08"
              },
              {
                  "title": "How to Train Your Dragon",
                  "genre": "Animation",
                  "director": "Dean DeBlois, Chris Sanders",
                  "release_date": "2010-03-26"
              },
              {
                  "title": "The Lego Movie",
                  "genre": "Animation",
                  "director": "Phil Lord, Christopher Miller",
                  "release_date": "2014-02-07"
              },
              {
                  "title": "Cloudy with a Chance of Meatballs",
                  "genre": "Animation",
                  "director": "Phil Lord, Chris Miller",
                  "release_date": "2009-09-18"
              },
              {
                  "title": "The Peanuts Movie",
                  "genre": "Animation",
                  "director": "Steve Martino",
                  "release_date": "2015-11-06"
              },
              {
                  "title": "The Croods",
                  "genre": "Animation",
                  "director": "Kirk DeMicco, Chris Sanders",
                  "release_date": "2013-03-22"
              },
              {
                  "title": "Trolls",
                  "genre": "Animation",
                  "director": "Mike Mitchell, Walt Dohrn",
                  "release_date": "2016-11-04"
              },
              {
                  "title": "Hotel Transylvania",
                  "genre": "Animation",
                  "director": "Genndy Tartakovsky",
                  "release_date": "2012-09-28"
              },
              {
                  "title": "The Emoji Movie",
                  "genre": "Animation",
                  "director": "Tony Leondis",
                  "release_date": "2017-07-28"
              },
              {
                  "title": "The Boss Baby",
                  "genre": "Animation",
                  "director": "Tom McGrath",
                  "release_date": "2017-03-31"
              },
              {
                  "title": "A Bug\'s Life",
                  "genre": "Animation",
                  "director": "John Lasseter, Andrew Stanton",
                  "release_date": "1998-11-25"
              },
              {
                  "title": "The Good Dinosaur",
                  "genre": "Animation",
                  "director": "Peter Sohn",
                  "release_date": "2015-11-25"
              },
              {
                  "title": "Brave",
                  "genre": "Animation",
                  "director": "Mark Andrews, Brenda Chapman",
                  "release_date": "2012-06-22"
              },
              {
                  "title": "Puss in Boots",
                  "genre": "Animation",
                  "director": "Chris Miller",
                  "release_date": "2011-10-28"
              },
              {
                  "title": "The Lorax",
                  "genre": "Animation",
                  "director": "Chris Renaud",
                  "release_date": "2012-03-02"
              },
              {
                  "title": "Madagascar",
                  "genre": "Animation",
                  "director": "Eric Darnell, Tom McGrath",
                  "release_date": "2005-05-27"
              },
              {
                  "title": "Rio",
                  "genre": "Animation",
                  "director": "Carlos Saldanha",
                  "release_date": "2011-04-15"
              },
              {
                  "title": "Sing",
                  "genre": "Animation",
                  "director": "Garth Jennings",
                  "release_date": "2016-12-21"
              },
              {
                  "title": "Space Jam",
                  "genre": "Animation",
                  "director": "Joe Pytka",
                  "release_date": "1996-11-15"
              },
              {
                  "title": "The Iron Giant",
                  "genre": "Animation",
                  "director": "Brad Bird",
                  "release_date": "1999-08-06"
              },
              {
                  "title": "The Little Mermaid",
                  "genre": "Animation",
                  "director": "Ron Clements, John Musker",
                  "release_date": "1989-11-17"
              },
              {
                  "title": "Mary Poppins",
                  "genre": "Musical",
                  "director": "Robert Stevenson",
                  "release_date": "1964-08-27"
              },
              {
                  "title": "The Sound of Music",
                  "genre": "Musical",
                  "director": "Robert Wise",
                  "release_date": "1965-03-02"
              },
              {
                  "title": "Grease",
                  "genre": "Musical",
                  "director": "Randal Kleiser",
                  "release_date": "1978-07-14"
              },
              {
                  "title": "Mamma Mia!",
                  "genre": "Musical",
                  "director": "Phyllida Lloyd",
                  "release_date": "2008-07-18"
              },
              {
                  "title": "La La Land",
                  "genre": "Musical",
                  "director": "Damien Chazelle",
                  "release_date": "2016-12-09"
              }
          ]',
                    'refusal' => NULL,
                  ),
                  'logprobs' => NULL,
                  'finish_reason' => 'stop',
                ),
              ),
              'usage' =>
              array (
                'prompt_tokens' => 72,
                'completion_tokens' => 1805,
                'total_tokens' => 1877,
                'prompt_tokens_details' =>
                array (
                  'cached_tokens' => 0,
                  'audio_tokens' => 0,
                ),
                'completion_tokens_details' =>
                array (
                  'reasoning_tokens' => 0,
                  'audio_tokens' => 0,
                  'accepted_prediction_tokens' => 0,
                  'rejected_prediction_tokens' => 0,
                ),
              ),
              'system_fingerprint' => 'fp_0705bf87c0',
            ),
            'status' => 200,
        );
    }
}
