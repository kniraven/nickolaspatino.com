<?php
declare(strict_types=1);

/*
    Author: Nickolas Patino
    Created: 04/09/2019
    Updated: 06/08/2026
*/

$projectRoot = dirname($_SERVER['DOCUMENT_ROOT']);
$pageLocked = "";

require_once $projectRoot . '/config/session.php';

$pageTitle = "Nickolas Patino | About Me";
$pageDescription = "Learn more about Nickolas Patino: local Wisconsin web developer, creator, RPG enthusiast, former competitive sabre fencer, dog lover, and practical problem solver based near Madison.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once $projectRoot . '/src/head.php'; ?>
</head>

<body>
    <header class="kn-site-header">
        <div class="kn-container kn-site-header-inner">
            <?php require_once $projectRoot . '/src/nav.php'; ?>
        </div>
    </header>

    <main>
        <!-- About Hero -->
        <section class="kn-page-hero">
            <div class="kn-container">
                <div class="kn-split kn-split-main">
                    <div class="kn-page-hero-content">
                        <p class="kn-small-text">
                            About Me
                        </p>

                        <h1>Web developer, creator, and practical builder.</h1>

                        <p class="kn-lead">
                            I am Nickolas Patino, a web developer based near Madison, Wisconsin. I build websites, small tools, and practical digital systems for people who need technology to be useful, organized, and understandable.
                        </p>

                        <p>
                            NickolasPatino.com is my professional site: a place for commissions, services, projects, and employer-facing work. When you work with me, you are working directly with a local, single-member Wisconsin small business.
                        </p>

                        <div class="kn-button-group">
                            <a href="/projects/" class="kn-button kn-button-primary">View Projects</a>
                            <a href="/contact.php" class="kn-button kn-button-secondary">Contact Me</a>
                            <a href="/services.php" class="kn-button kn-button-ghost">Services</a>
                        </div>
                    </div>

                    <aside class="kn-card kn-card-compact kn-stack kn-stack-tight" aria-label="Quick facts about Nickolas Patino">
                        <div class="kn-card-media kn-aspect-photo kn-feature-image">
                            <img
                                src="/assets/images/portrait.png"
                                alt="Nickolas Patino"
                                width="1200"
                                height="800"
                            >
                        </div>

                        <div class="kn-stack kn-stack-tight">
                            <h2>Nickolas Patino</h2>

                            <ul class="kn-feature-list">
                                <li>Local Wisconsin web developer</li>
                                <li>Single-member small business owner</li>
                                <li>RPG, MMO, and TTRPG enthusiast</li>
                                <li>Former competitive college sabre fencer</li>
                                <li>Dog owner: Molly, Titan, and Czar</li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <!-- Building and Web Origin -->
        <section>
            <div class="kn-container">
                <div class="kn-section-header">
                    <p class="kn-small-text">
                        How I Started
                    </p>

                    <h2>I started by making digital spaces feel personal.</h2>
                </div>

                <div class="kn-text-block kn-stack kn-stack-loose">
                    <p>
                        I first learned HTML, CSS, and JavaScript in high school so I could customize my MySpace page. I did not start with a career plan. I wanted control over how something looked, how it felt, and how people experienced it.
                    </p>

                    <p>
                        That same interest carried into gaming. I learned more so I could create forums for my guild in an MMORPG, which made web development feel connected to communities, identity, and the places people gather online.
                    </p>

                    <p>
                        After I moved to Madison, a friend pushed me to stop figuring things out randomly and learn web development the proper way. That convinced me to pursue a degree in web application development and take the skill seriously.
                    </p>
                </div>
            </div>
        </section>

        <!-- Personal Background -->
        <section class="kn-section-tight">
            <div class="kn-container">
                <article class="kn-card kn-stack kn-stack-loose">
                    <p class="kn-small-text">
                        Why I Build This Way
                    </p>

                    <h2>I care about stability because I know what instability feels like.</h2>

                    <p>
                        I was homeless for much of my life up until about age 20, moving through shelters, churches, convents, campgrounds, and other temporary places. That shaped how I approach work: I pay attention, adapt quickly, and try to turn messy situations into something stable, practical, and usable.
                    </p>
                </article>
            </div>
        </section>

        <!-- Games and Online Communities -->
        <section>
            <div class="kn-container">
                <div class="kn-section-header">
                    <p class="kn-small-text">
                        Games, Communities &amp; Content
                    </p>

                    <h2>A lot of my creative work comes from games and online communities.</h2>

                    <p>
                        Games have been more than entertainment for me. They are where I learned about community spaces, guild leadership, competition, storytelling, systems, and long-term creative projects.
                    </p>
                </div>

                <div class="kn-card-grid">
                    <article class="kn-card kn-card-equal kn-stack">
                        <h3>MMOs &amp; PvP</h3>

                        <p>
                            I have spent a lot of time with Final Fantasy XIV, Perfect World International, New World, and EVE Online. I am usually drawn toward PvP, factions, guilds, builds, progression, and competitive scenes.
                        </p>
                    </article>

                    <article class="kn-card kn-card-equal kn-stack">
                        <h3>Guild Leadership</h3>

                        <p>
                            I have been a guild leader in multiple MMORPGs. I like coordinating people, setting goals, building groups, and figuring out how a team can improve.
                        </p>
                    </article>

                    <article class="kn-card kn-card-equal kn-stack">
                        <h3>TTRPGs &amp; Worldbuilding</h3>

                        <p>
                            I like tabletop games because they combine rules, storytelling, creativity, problem solving, group dynamics, and worldbuilding.
                        </p>
                    </article>

                    <article class="kn-card kn-card-equal kn-stack">
                        <h3>Video &amp; Streaming</h3>

                        <p>
                            I like making lore and PvP videos about games, and I stream 24/7 so people can stop by, talk, connect, or leave a message.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Creator Setup -->
        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-media">
                    <div class="kn-card kn-card-compact">
                        <div class="kn-card-media kn-aspect-video kn-feature-image">
                            <img
                                src="/assets/images/workspace.png"
                                alt="Nickolas Patino's workspace, gaming setup, or creator setup"
                                width="1600"
                                height="900"
                            >
                        </div>
                    </div>

                    <div class="kn-stack kn-stack-loose">
                        <div class="kn-section-header">
                            <p class="kn-small-text">
                                Creator Setup
                            </p>

                            <h2>I like building the whole system around the work.</h2>
                        </div>

                        <div class="kn-text-block kn-stack kn-stack-loose">
                            <p>
                                My interest in creating online is not only the content itself. I also enjoy the setup behind it: websites, editing software, cameras, lighting, green screens, livestreaming tools, and the technical workflow that makes everything function.
                            </p>

                            <p>
                                Over time, I have built up high-end streamer equipment, multiple green screens, and even a livestreaming backpack. That mix of hardware, software, and presentation is part of why web development, tools, and digital systems appeal to me.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dogs -->
        <section class="kn-section-tight">
            <div class="kn-container">
                <div class="kn-split kn-split-media-reverse">
                    <div class="kn-stack kn-stack-loose">
                        <div class="kn-section-header">
                            <p class="kn-small-text">
                                Home Life
                            </p>

                            <h2>Molly, Czar, and Titan are all adopted or rescued.</h2>
                        </div>

                        <div class="kn-text-block kn-stack kn-stack-loose">
                            <p>
                                Molly is the leader of the pack and was the first dog I adopted. She is an Alaskan Malamute who had been cooped up in a small downtown studio apartment with many people and other animals. Her previous home did not know her breed and did not realize how large she would get, so she was released to me.
                            </p>

                            <p>
                                Czar came next. He is a Siberian Husky whose owner had unfortunate circumstances and medical issues that required moving into a much smaller space. I adopted him so Molly would have a friend to run around the yard with.
                            </p>

                            <p>
                                Titan came third. He is a Saint Bernard I found online. He was extremely dirty, matted, underweight, had very long nails, and had been kept in a kennel far too small for him. He gets along great with other animals, even small critters, but he is still leery of new humans.
                            </p>
                        </div>
                    </div>

                    <div class="kn-card kn-card-compact">
                        <div class="kn-card-media kn-aspect-video kn-feature-image">
                            <img
                                src="/assets/images/dogs.png"
                                alt="Czar the Siberian Husky, Titan the Saint Bernard, and Molly the Alaskan Malamute"
                                width="1600"
                                height="900"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Competitive Background -->
        <section>
            <div class="kn-container">
                <article class="kn-card kn-stack kn-stack-loose">
                    <p class="kn-small-text">
                        Competition &amp; Leadership
                    </p>

                    <h2>I have always been drawn to competitive spaces.</h2>

                    <p>
                        In MMORPGs, I have been a guild leader multiple times and have often been part of the competitive PvP scene. I like strategy, roles, pressure, coordination, and figuring out how to improve.
                    </p>

                    <p>
                        I was also highly competitive in sabre fencing at Santa Rosa Junior College in California, where I grew up. I took several years of fencing courses, became the teaching assistant for advanced sabre, and served as president of the school’s fencing club.
                    </p>
                </article>
            </div>
        </section>

        <!-- Professional Direction -->
        <section>
            <div class="kn-container">
                <div class="kn-section-header">
                    <p class="kn-small-text">
                        Professional Direction
                    </p>

                    <h2>My professional work and gaming brand have different homes.</h2>
                </div>

                <div class="kn-text-block kn-stack kn-stack-loose">
                    <p>
                        Because my work crosses web development, online communities, games, streaming, and product ideas, I keep my sites separated by purpose.
                    </p>

                    <p>
                        NickolasPatino.com is for explaining who I am professionally, showing my web development work, offering commissions and services, and giving potential employers a clear place to review my projects.
                    </p>

                    <p>
                        Kniraven.com is the brand site I am building for TTRPG and video game products. Long-term, that is where I plan to sell creative gaming products, tools, and related projects.
                    </p>
                </div>
            </div>
        </section>

        <!-- Education -->
        <section>
            <div class="kn-container">
                <div class="kn-split kn-split-media">
                    <div class="kn-card kn-card-compact kn-graphic-plate kn-center-content">
                        <img
                            src="/assets/images/madisoncollege300x200.png"
                            alt="Madison Area Technical College logo"
                            class="kn-media-logo"
                            width="300"
                            height="200"
                        >
                    </div>

                    <div class="kn-stack kn-stack-loose">
                        <div class="kn-section-header">
                            <p class="kn-small-text">
                                Formal Training
                            </p>

                            <h2>Web application development at Madison College.</h2>
                        </div>

                        <div class="kn-text-block kn-stack kn-stack-loose">
                            <p>
                                I studied IT: Web Application Development at Madison Area Technical College and maintained a 4.0 GPA. My coursework focused on web development, databases, UX/UI, accessibility, and practical software development fundamentals.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact CTA -->
        <section class="kn-section-tight">
            <div class="kn-container">
                <div class="kn-card kn-stack kn-stack-loose">
                    <p class="kn-small-text">
                        Work With Me
                    </p>

                    <h2>Need a website, tool, or practical technical help?</h2>

                    <p>
                        Work directly with a local web developer based near Madison, Wisconsin. I can help with websites, small business tech, workflows, digital tools, and project ideas that need someone practical to build or organize them.
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <a href="mailto:nickolas@kniraven.com">nickolas@kniraven.com</a>
                    </p>

                    <div class="kn-button-group">
                        <a href="/contact.php" class="kn-button kn-button-primary">Contact Me</a>
                        <a href="/projects/" class="kn-button kn-button-secondary">View Projects</a>
                        <a href="/assets/files/nickolas-patino-contact-card.pdf" class="kn-button kn-button-ghost">Download Contact Card</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="kn-site-footer">
        <div class="kn-container kn-site-footer-inner">
            <?php require_once $projectRoot . '/src/footer.php'; ?>
        </div>
    </footer>
</body>
</html>