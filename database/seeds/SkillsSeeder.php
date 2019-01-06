<?php

use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        auth()->loginUsingId(5);

        $skills = [
            [
                'icon'          => 'code',
                'title'         => 'PHP',
                'color'         => '#448AFF',
                'slug'          => 'php',
                'description'   => 'PHP (recursive acronym for PHP: Hypertext Preprocessor) is a widely-used open source general-purpose scripting language that is especially suited for web development and can be embedded into HTML.'
            ],
            [
                'icon'          => 'code',
                'title'         => 'HTML',
                'color'         => '#689F38',
                'slug'          => 'html',
                'description'   => 'HTML (Hypertext Markup Language) is a text-based approach to describing how content contained within an HTML file is structured. This markup tells a web browser how to display the text, images and other forms of multimedia on a webpage.'
            ],
            [
                'icon'          => 'code',
                'title'         => 'JavaScript',
                'color'         => '#9C27B0',
                'slug'          => 'javascript',
                'description'   => 'JavaScript is a scripting or programming language that allows you to implement complex things on web pages — every time a web page does more than just sit there and display static information for you to look at — displaying timely content updates, interactive maps, animated 2D/3D graphics, scrolling video jukeboxes, etc. — you can bet that JavaScript is probably involved. It is the third layer of the layer cake of standard web technologies, two of which (HTML and CSS) we have covered in much more detail in other parts of the Learning Area.'
            ],
            [
                'icon'          => 'code',
                'title'         => 'CSS',
                'color'         => '#D32F2F',
                'slug'          => 'css',
                'description'   => 'Cascading Style Sheets, fondly referred to as CSS, is a simple design language intended to simplify the process of making web pages presentable.'
            ],
            [
                'icon'          => 'desktop',
                'title'         => 'Active Directory',
                'color'         => '#26A69A',
                'slug'          => 'active-directory',
                'description'   => 'Active Directory (AD) is a directory service that Microsoft developed for the Windows domain networks. It is included in most Windows Server operating systems as a set of processes and services. Initially, Active Directory was only in charge of centralized domain management. Starting with Windows Server 2008, however, Active Directory became an umbrella title for a broad range of directory-based identity-related services.'
            ],
            [
                'icon'          => 'laptop',
                'title'         => 'Windows 10',
                'color'         => '#FF5722',
                'slug'          => 'windows-10',
                'description'   => 'Windows 10 is a Microsoft operating system for personal computers, tablets, embedded devices and internet of things devices.'
            ],
            [
                'icon'          => 'mobile-phone',
                'title'         => 'iOS',
                'color'         => '#AB47BC',
                'slug'          => 'ios',
                'description'   => 'iOS is Apple\'s mobile operating system that runs the iPhone, iPad, and iPod Touch devices. Originally known as the iPhone OS, the name was changed with the introduction of the iPad.'
            ],
            [
                'icon'          => 'user',
                'title'         => 'HCSIS',
                'color'         => '#448AFF',
                'slug'          => 'hcsis',
                'description'   => 'HCSIS is the name of the information system. PELICAN is the umbrella name that DPW uses to have consistent branding throughout its early learning technology systems.'
            ]
        ];

        foreach($skills as $skill)
        {
            \App\Skill::create($skill);
        }
    }
}
