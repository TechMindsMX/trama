<?php
/**
 * @package		JomSocial
 * @subpackage	Library 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class CAkismet implements CSpamFilter_Service
{
	var $_filter	= null;
	var $_author	= null;
	var $_message	= null;
	var $_type		= null;
	var $_email		= null;
	var $_ip		= null;
	var $_useragent	= null;
	var $_referrer	= null;

	public function __construct()
	{
		$config		= CFactory::getConfig();
		
		if( !$config->get( 'antispam_akismet_key' ) || !$config->get( 'antispam_enable' ) )
		{
			return false;
		}
		
		$this->_filter	= new Akismet(JURI::root(), $config->get( 'antispam_akismet_key' ) ); 
		//request put more information from Askimet
		$this->_filter->setCommentUserAgent("Jomsocial/1.23 | Akismet/1.1");
		
	}

	/**
	 * Sets the current author of the object or task.
	 * 
	 * @param	string	$author		An identifier for the author which we want to screen.
	 **/
	public function setAuthor( $author )
	{
		$this->_author = $author;
	}

	/**
	 * Sets the current message of the object or task.
	 * 
	 * @param	string	$message		An identifier for the message which we want to screen.
	 **/
	public function setMessage( $message )
	{
		$this->_message	= $message;
	}

	/**
	 * Sets the current url for the request
	 * 
	 * @param	string	$url		An identifier for the url which we want to screen.
	 **/
	public function setURL( $url = '' )
	{
		$this->_url		= empty( $url ) ? JURI::root() : $url;
	}

	/**
	 * Sets the current url for the request
	 * 
	 * @param	string	$url		An identifier for the url which we want to screen.
	 **/	
	public function setType( $type )
	{
		$this->_type	= $type;
	}

	/**
	 * Sets the current url for the request
	 * 
	 * @param	string	$url		An identifier for the url which we want to screen.
	 **/
	public function setEmail( $email )
	{
		$this->_email	= $email;
	}

	/**
	 * Sets the current url for the request
	 * 
	 * @param	string	$url		An identifier for the url which we want to screen.
	 **/
	public function setIP( $ip )
	{
		$this->_ip		= $ip;
	}

	/**
	 * Sets the current url for the request
	 * 
	 * @param	string	$url		An identifier for the url which we want to screen.
	 **/
	public function setUserAgent( $useragent )
	{
		$this->_useragent	= $useragent;
	}

	/**
	 * Sets the current url for the request
	 * 
	 * @param	string	$url		An identifier for the url which we want to screen.
	 **/
	public function setReferrer( $referrer )
	{
		$this->_referrer	= $referrer;
	}
	
	/**
	 * Builds up the query we have and submits to the server for screening
	 * 
	 * @return	boolean	True if item marked spam and false otherwise.
	 **/
	public function isSpam()
	{
		$config		= CFactory::getConfig();

		if( !$config->get( 'antispam_akismet_key' ) || !$config->get( 'antispam_enable' ) )
		{
			return false;
		}
				
		if( is_null( $this->_useragent ) )
		{
			$this->_useragent	= JBrowser::getInstance()->getAgentString();
		}

		$this->_filter->setCommentAuthor($this->_author);
		$this->_filter->setCommentAuthorEmail($this->_email);
		$this->_filter->setCommentAuthorURL($this->_url);
		$this->_filter->setCommentContent($this->_message);
		$this->_filter->setPermalink($this->_url);

		return !$this->_filter->isKeyValid();
	}
}
