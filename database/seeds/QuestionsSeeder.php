<?php

use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'title'         => 'What is the sign for strict equals?',
                'lecture_id'    => 2,
                'answers'       => [
                    [
                        'title'     => '>=',
                        'correct'   => false
                    ],
                    [
                        'title'     => '==',
                        'correct'   => false
                    ],
                    [
                        'title'     => '===',
                        'correct'   => true
                    ],
                    [
                        'title'     => '=..=',
                        'correct'   => false
                    ],
                ]
            ],
            [
                'title'         => 'What is the sign for loose equals?',
                'lecture_id'    => 2,
                'answers'       => [
                    [
                        'title'     => '%',
                        'correct'   => false
                    ],
                    [
                        'title'     => '==',
                        'correct'   => true
                    ],
                    [
                        'title'     => '===',
                        'correct'   => false
                    ],
                    [
                        'title'     => '=..=',
                        'correct'   => false
                    ],
                ]
            ],
            [
                'title'         => 'What is the first parameter is a for loop?',
                'lecture_id'    => 2,
                'answers'       => [
                    [
                        'title'     => 'The starting iteration point',
                        'correct'   => true
                    ],
                    [
                        'title'     => 'The increment value',
                        'correct'   => false
                    ],
                    [
                        'title'     => 'The loop condition',
                        'correct'   => false
                    ],
                    [
                        'title'     => 'The array of items to loop over',
                        'correct'   => false
                    ],
                ]
            ],
        ];

        foreach($questions as $question)
        {
            $new_question = \App\Question::create([
                'title'         => $question['title'],
                'lecture_id'    => $question['lecture_id']
            ]);

            foreach($question['answers'] as $answer)
            {
                $new_answer = $new_question->answers()->create([
                    'title' => $answer['title']
                ]);

                if($answer['correct']) $new_question->update(['answer_id' => $new_answer->id]);
            }
        }
    }
}
