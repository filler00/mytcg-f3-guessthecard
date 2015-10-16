<?php

namespace Plugins\Filler00\MyTCGf3GuessTheCard\App\Controllers;

use Template;

class GuessTheCard {
	
	protected $f3;
	protected $db;
	protected $game;
	protected $gameData;
	protected $viewFile;
	protected $templateFile;
	
	function __construct( $f3, $db, $game, $gameData ) {
		$this->f3 = $f3;
		$this->db = $db;
		$this->game = $game;
		$this->gameData = $gameData;
		
		$this->viewFile = 'app/plugins/filler00/mytcgf3guessthecard/app/views/guess-the-card.htm';
		$this->templateFile = 'app/templates/default.htm';
		
		//$this->f3->push('ASSETS.css', 'app/plugins/filler00/mytcgf3guessthecard/assets/css/styles.css');
		$this->f3->push('ASSETS.js', 'app/plugins/filler00/mytcgf3guessthecard/assets/js/scripts.js');
		
	}

	public function run() {
		
		$this->f3->set('game', $this->game);
		$this->f3->set('gameData', $this->gameData);
		
		$currentRound = $this->gameData['current-round'];
		$roundData = $this->gameData['rounds'][$currentRound - 1];
		
		$this->f3->set('roundData', $roundData);
		$this->f3->set('answers', [ $roundData['answer1'], $roundData['answer2'], $roundData['answer3'] ] );
		$this->f3->set('hints', [ $roundData['hint1'], $roundData['hint2'], $roundData['hint3'] ] );
		$this->f3->set('cards', [ $roundData['card1'], $roundData['card2'], $roundData['card3'] ] );
		
		$win = true;
		foreach ( $this->f3->get('answers') as $index => $answer ) {
		    if ( $this->f3->exists('POST.guesses['.$index.']') && !empty($this->f3->get('POST.guesses['.$index.']')) ) {
		    	$this->f3->set('guesses['.$index.']', $this->f3->get('POST.guesses['.$index.']'));
		    }
		    if ( $answer !==  $this->f3->get('guesses['.$index.']') ) {
		        $win = false;
		    }
		}
		
		$this->f3->set('win', $win);
		
		$this->f3->set('content', $this->viewFile); 
		echo Template::instance()->render( $this->templateFile );
		
	}
	
}