<?php

namespace spec\WITR\Slideshow;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use WITR\Schedule\ScheduledShow;
use WITR\Event;

class SlideSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WITR\Slideshow\Slide');
    }

    function it_should_display_now_playing_for_current_show(ScheduledShow $show)
    {
    	$this->beConstructedThrough('fromScheduledShow', [$show]);
    	$this->playOrder(0);
    	$this->displayText()->shouldBe('&#9658;&nbsp;Now Playing');
    }

    function it_should_display_up_next_for_following_show(ScheduledShow $show)
    {
    	$this->beConstructedThrough('fromScheduledShow', [$show]);
    	$this->playOrder(1);
    	$this->displayText()->shouldBe('Up Next:');
    }

    function it_should_display_relative_air_date_for_other_shows(ScheduledShow $show)
    {
    	$show->getRelativeAirDate()->willReturn('Wednesday');
    	$show->timespan()->willReturn('1 - 3 AM');
    	$this->beConstructedThrough('fromScheduledShow', [$show]);
    	$this->playOrder(2);
    	$this->displayText()->shouldBe('Wednesday 1 - 3 AM');
    	$this->playOrder(3);
    	$this->displayText()->shouldBe('Wednesday 1 - 3 AM');
    }

    function it_should_display_a_shows_slider_image(ScheduledShow $show)
    {
    	$show->sliderPicture()->willReturn('slider.jpg');
    	$this->beConstructedThrough('fromScheduledShow', [$show]);
    	$this->image()->shouldBe('slider.jpg');
    }

    function it_should_return_a_shows_slider_style(ScheduledShow $show)
    {
    	$show->sliderStyle()->willReturn('display: none');
    	$this->beConstructedThrough('fromScheduledShow', [$show]);
    	$this->textStyle()->shouldBe('display: none');
    }

    function it_should_return_no_url_for_a_show(ScheduledShow $show)
    {
    	$this->beConstructedThrough('fromScheduledShow', [$show]);
    	$this->url()->shouldBeNull();
    }

    function it_should_display_no_text_for_an_event(Event $event)
    {
    	$this->beConstructedThrough('fromEvent', [$event]);
    	$this->displayText()->shouldBeNull();
    }

    function it_should_display_an_image_for_an_event()
    {
    	$event = new Event;
    	$event->picture = 'event.jpg';
    	$this->beConstructedThrough('fromEvent', [$event]);
    	$this->image()->shouldBe('event.jpg');
    }

    function it_should_display_a_url_for_an_event()
    {
    	$event = new Event;
    	$event->url = 'google.com';
    	$this->beConstructedThrough('fromEvent', [$event]);
    	$this->url()->shouldBe('google.com');
    }

    function it_should_not_display_a_slider_text_style(Event $event)
    {
    	$this->beConstructedThrough('fromEvent', [$event]);
    	$this->textStyle()->shouldBeNull();
    }

    function it_should_return_show_type_for_shows(ScheduledShow $show)
    {
        $this->beConstructedThrough('fromScheduledShow', [$show]);
        $this->type()->shouldBe('SHOW');
    }

    function it_should_return_event_type_for_events(Event $event)
    {
        $this->beConstructedThrough('fromEvent', [$event]);
        $this->type()->shouldBe('EVENT');
    }

    function it_should_return_index_for_slide(Event $event)
    {
        $this->beConstructedThrough('fromEvent', [$event]);
        $this->index(0);
        $this->displayIndex()->shouldBe('first');
        $this->index(3);
        $this->displayIndex()->shouldBe('fourth');
    }
}
