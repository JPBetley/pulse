<?php

namespace spec\WITR\Schedule;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WITR\Show;
use WITR\DJ;
use WITR\Schedule\ScheduledShow;
use WITR\Schedule\ScheduleTime;
use Carbon\Carbon;

class ScheduledShowSpec extends ObjectBehavior
{
	function let()
	{
		$show = new Show([
			'name' => 'The Pulse Of Music',
			'show_picture' => 'show.jpg',
			'slider_picture' => 'slider.jpg',
			'style' => 'display: none;',
			'description' => 'Show Description'
		]);
		$show->id = 2;

		$dj = new DJ([
			'name' => 'Philosopher',
			'picture' => 'dj.jpg'
		]);
		$dj->id = 1;

		$this->beConstructedThrough('fromShowAndDJ', [$show, $dj]);
	}

	function it_should_return_time_slot_id()
	{
		$this->setId(100);
		$this->id()->shouldBe(100);
	}

	function it_should_display_a_name()
	{
		$this->dj()->shouldBe('Philosopher');
	}

	function it_should_return_a_dj_id()
	{
		$this->djId()->shouldBe(1);
	}

	function it_should_display_a_show_name()
	{
		$this->show()->shouldBe('The Pulse Of Music');
	}

	function it_should_return_a_show_id()
	{
	  $this->showId()->shouldBe(2);
	}

	function it_should_return_the_djs_picture()
	{
		$this->djPicture()->shouldBe('dj.jpg');
	}

	function it_should_return_the_show_picture()
	{
		$this->showPicture()->shouldBe('show.jpg');
	}

	function it_should_return_the_slider_picture()
	{
		$this->sliderPicture()->shouldBe('slider.jpg');
	}

	function it_should_return_the_slider_style()
	{
	  $this->sliderStyle()->shouldBe('display: none;');
	}

	function it_should_typically_end_an_hour_after_start_time()
	{
		$this->startsAt(1);
		$this->start()->shouldBe(1);
		$this->end()->shouldBe(2);
	}

	function it_can_span_several_hour_long_intervals()
	{
		$this->startsAt(1);
		$this->extendShowByHour();
		$this->start()->shouldBe(1);
		$this->end()->shouldBe(3);

		$this->extendShowByHour();
		$this->start()->shouldBe(1);
		$this->end()->shouldBe(4);

		$this->startsAt(23);
		$this->extendShowByHour();
		$this->start()->shouldBe(23);
		$this->end()->shouldBe(25);
	}

	function it_should_display_a_time_span()
	{
		$this->startsAt(1);
		$this->extendShowByHour();
		$this->timespan()->shouldBe('1 - 3 AM');

		$this->startsAt(12);
		$this->extendShowByHour();
		$this->timespan()->shouldBe('12 - 2 PM');

		$this->startsAt(14);
		$this->extendShowByHour();
		$this->timespan()->shouldBe('2 - 4 PM');

		$this->startsAt(24);
		$this->timespan()->shouldBe('12 - 1 AM');
	}

	function it_should_return_air_date_for_each_day_of_the_week()
	{
		$this->airsDayOfWeek(0);
		$this->getAirDate()->shouldBe('Sunday');

		$this->airsDayOfWeek(1);
		$this->getAirDate()->shouldBe('Monday');
		
		$this->airsDayOfWeek(2);
		$this->getAirDate()->shouldBe('Tuesday');
		
		$this->airsDayOfWeek(3);
		$this->getAirDate()->shouldBe('Wednesday');
		
		$this->airsDayOfWeek(4);
		$this->getAirDate()->shouldBe('Thursday');
		
		$this->airsDayOfWeek(5);
		$this->getAirDate()->shouldBe('Friday');
		
		$this->airsDayOfWeek(6);
		$this->getAirDate()->shouldBe('Saturday');
	}

	function it_should_return_relative_air_date_for_shows_airing_today()
	{
		$today = ScheduleTime::now()->dayOfWeek(); 
		$this->airsDayOfWeek($today);
		$this->getRelativeAirDate()->shouldBe('Today');
	}

	function it_should_return_relative_air_date_for_shows_airing_tomorrow()
	{
		$tomorrow = ScheduleTime::now()->addDay()->dayOfWeek; 
		$this->airsDayOfWeek($tomorrow);
		$this->getRelativeAirDate()->shouldBe('Tomorrow');
	}

	function it_should_return_air_date_for_shows_airing_on_day_other_than_today_or_tomorrow()
	{
		$nextDay = ScheduleTime::now()->addDays(2)->dayOfWeek;
		$this->airsDayOfWeek($nextDay);
		$this->getRelativeAirDate()->shouldNotBe('Today');
		$this->getRelativeAirDate()->shouldNotBe('Tomorrow');
	}

	function it_should_return_air_day_of_week()
	{
		$this->airsDayOfWeek(3);
		$this->airDayOfWeek()->shouldBe(3);
	}

	function it_should_return_a_show_description()
	{
		$this->showDescription()->shouldBe('Show Description');
	}

	function it_should_return_if_show_is_now_playing()
	{
		$this->nowPlaying()->shouldBe(false);

		$today = ScheduleTime::now();
		$this->airsDayOfWeek($today->dayOfWeek());
		$this->startsAt($today->hour());
		$this->nowPlaying()->shouldBe(true);

		$this->startsAt($today->hour() - 1);
		$this->nowPlaying()->shouldBe(false);
		$this->extendShowByHour();
		$this->nowPlaying()->shouldBe(true);
	}
}
