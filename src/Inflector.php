<?php
/**
 * @package    Fuel\Common
 * @version    2.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Common;

/**
 * Some of this code was written by Flinn Mueller.
 *
 * @package		Fuel
 * @category	Common
 * @copyright	Flinn Mueller
 * @link		http://docs.fuelphp.com/classes/inlector.html
 */
class Inflector
{
	/**
	 * @var  array  List of uncountable words
	 */
	protected $uncountableWords = array(
		'equipment', 'information', 'rice', 'money',
		'species', 'series', 'fish', 'meta'
	);

	/**
	 * @var  array  Regex rules for pluralisation
	 */
	protected $pluralRules = array(
		'/^(ox)$/i'                 => '\1\2en',     // ox
		'/([m|l])ouse$/i'           => '\1ice',      // mouse, louse
		'/(matr|vert|ind)ix|ex$/i'  => '\1ices',     // matrix, vertex, index
		'/(x|ch|ss|sh)$/i'          => '\1es',       // search, switch, fix, box, process, address
		'/([^aeiouy]|qu)y$/i'       => '\1ies',      // query, ability, agency
		'/(hive)$/i'                => '\1s',        // archive, hive
		'/(?:([^f])fe|([lr])f)$/i'  => '\1\2ves',    // half, safe, wife
		'/sis$/i'                   => 'ses',        // basis, diagnosis
		'/([ti])um$/i'              => '\1a',        // datum, medium
		'/(p)erson$/i'              => '\1eople',    // person, salesperson
		'/(m)an$/i'                 => '\1en',       // man, woman, spokesman
		'/(c)hild$/i'               => '\1hildren',  // child
		'/(buffal|tomat)o$/i'       => '\1\2oes',    // buffalo, tomato
		'/(bu|campu)s$/i'           => '\1\2ses',    // bus, campus
		'/(alias|status|virus)$/i'  => '\1es',       // alias
		'/(octop)us$/i'             => '\1i',        // octopus
		'/(ax|cris|test)is$/i'      => '\1es',       // axis, crisis
		'/s$/'                     => 's',          // no change (compatibility)
		'/$/'                      => 's',
	);

	/**
	 * @var  array  Regex rules for singularisation
	 */
	protected $singularRules = array(
		'/(matr)ices$/i'         => '\1ix',
		'/(vert|ind)ices$/i'     => '\1ex',
		'/^(ox)en/i'             => '\1',
		'/(alias)es$/i'          => '\1',
		'/([octop|vir])i$/i'     => '\1us',
		'/(cris|ax|test)es$/i'   => '\1is',
		'/(shoe)s$/i'            => '\1',
		'/(o)es$/i'              => '\1',
		'/(bus|campus)es$/i'     => '\1',
		'/([m|l])ice$/i'         => '\1ouse',
		'/(x|ch|ss|sh)es$/i'     => '\1',
		'/(m)ovies$/i'           => '\1\2ovie',
		'/(s)eries$/i'           => '\1\2eries',
		'/([^aeiouy]|qu)ies$/i'  => '\1y',
		'/([lr])ves$/i'          => '\1f',
		'/(tive)s$/i'            => '\1',
		'/(hive)s$/i'            => '\1',
		'/([^f])ves$/i'          => '\1fe',
		'/(^analy)ses$/i'        => '\1sis',
		'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
		'/([ti])a$/i'            => '\1um',
		'/(p)eople$/i'           => '\1\2erson',
		'/(m)en$/i'              => '\1an',
		'/(s)tatuses$/i'         => '\1\2tatus',
		'/(c)hildren$/i'         => '\1\2hild',
		'/(n)ews$/i'             => '\1\2ews',
		'/([^us])s$/i'           => '\1',
	);

	/**
	 * @var  Fuel\Config\Config  Instance of a Fuel config container
	 */
	protected $config;

	/**
	 * @var  Fuel\Security\Manager  Instance of a Fuel security manager
	 */
	protected $security;

	/**
	 * @var  Fuel\Common\Str  Instance of a Fuel string helper
	 */
	protected $str;

	/**
	 * Class constructor
	 *
	 * @param  Fuel\Config\Config     $config    Instance of a Fuel config container
	 * @param  Fuel\Security\Manager  $security  Instance of a Fuel security manager
	 *
	 * @return  void
	 *
	 * @since 2.0.0
	 */
	public function __construct($config = null, $security = null, $str = null)
	{
		$this->config = $config;
		$this->security = $security;
		$this->str = $str;
	}

	/**
	 * Add order suffix to numbers ex. 1st 2nd 3rd 4th 5th
	 *
	 * @param   int     the number to ordinalize
	 * @return  string  the ordinalized version of $number
	 * @link    http://snipplr.com/view/4627/a-function-to-add-a-prefix-to-numbers-ex-1st-2nd-3rd-4th-5th/
	 */
	public function ordinalize($number)
	{
		if ( ! is_numeric($number))
		{
			return $number;
		}

		if (in_array(($number % 100), range(11, 13)))
		{
			return $number . 'th';
		}
		else
		{
			switch ($number % 10)
			{
				case 1:
					return $number . 'st';
					break;
				case 2:
					return $number . 'nd';
					break;
				case 3:
					return $number . 'rd';
					break;
				default:
					return $number . 'th';
					break;
			}
		}
	}

	/**
	 * Gets the plural version of the given word
	 *
	 * @param   string  the word to pluralize
	 * @param   int     number of instances
	 * @return  string  the plural version of $word
	 */
	public function pluralize($word, $count = 0)
	{
		$result = strval($word);

		// If a counter is provided, and that equals 1
		// return as singular.
		if ($count === 1)
		{
			return $result;
		}

		if ( ! $this->isCountable($result))
		{
			return $result;
		}

		foreach ($this->pluralRules as $rule => $replacement)
		{
			if (preg_match($rule, $result))
			{
				$result = preg_replace($rule, $replacement, $result);
				break;
			}
		}

		return $result;
	}

	/**
	 * Gets the singular version of the given word
	 *
	 * @param   string  the word to singularize
	 * @return  string  the singular version of $word
	 */
	public function singularize($word)
	{
		$result = strval($word);

		if ( ! $this->isCountable($result))
		{
			return $result;
		}

		foreach ($this->singularRules as $rule => $replacement)
		{
			if (preg_match($rule, $result))
			{
				$result = preg_replace($rule, $replacement, $result);
				break;
			}
		}

		return $result;
	}

	/**
	 * Takes a string that has words seperated by underscores and turns it into
	 * a CamelCased string.
	 *
	 * @param   string  the underscored word
	 * @return  string  the CamelCased version of $underscored_word
	 */
	public function camelize($underscored_word)
	{
		return preg_replace_callback(
			'/(^|_)(.)/',
			function ($parm)
			{
				return strtoupper($parm[2]);
			},
			strval($underscored_word)
		);
	}

	/**
	 * Takes a CamelCased string and returns an underscore separated version.
	 *
	 * @param   string  the CamelCased word
	 * @return  string  an underscore separated version of $camel_cased_word
	 */
	public function underscore($camel_cased_word)
	{
		return $this->str->lower(preg_replace('/([A-Z]+)([A-Z])/', '\1_\2', preg_replace('/([a-z\d])([A-Z])/', '\1_\2', strval($camel_cased_word))));
	}

	/**
	 * Translate string to 7-bit ASCII
	 * Only works with UTF-8.
	 *
	 * @param   string  $str              string to translate
	 * @param   bool    $allow_non_ascii  wether to remove non ascii
	 * @return  string                    translated string
	 */
	public function ascii($str, $allow_non_ascii = false)
	{
		// Translate unicode characters to their simpler counterparts
		$this->config->load('ascii', true);
		$foreign_characters = $this->config->get('ascii');

		$str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);

		if ( ! $allow_non_ascii)
		{
			return preg_replace('/[^\x09\x0A\x0D\x20-\x7E]/', '', $str);
		}

		return $str;
	}

	/**
	 * Converts your text to a URL-friendly title so it can be used in the URL.
	 * Only works with UTF8 input and and only outputs 7 bit ASCII characters.
	 *
	 * @param   string  $str              the text
	 * @param   string  $sep              the separator (either - or _)
	 * @param   bool    $lowercase        wether to convert to lowercase
	 * @param   bool    $allow_non_ascii  wether to allow non ascii
	 * @return  string                    the new title
	 */
	public function friendlyTitle($str, $sep = '-', $lowercase = false, $allow_non_ascii = false)
	{
		// Allow underscore, otherwise default to dash
		$sep = $sep === '_' ? '_' : '-';

		// Remove tags
		$str = $this->security->stripTags($str);

		// Decode all entities to their simpler forms
		$str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');

		// Replace apostrophes.
		$str = preg_replace("#[\’]#", '-', $str);

		// Remove all quotes.
		$str = preg_replace("#[\"\']#", '', $str);

		// Only allow 7bit characters
		$str = $this->ascii($str, $allow_non_ascii);

		if ($allow_non_ascii)
		{
			// Strip regular special chars.
			$str = preg_replace("#[\.;:'\"\]\}\[\{\+\)\(\*&\^\$\#@\!±`%~']#iu", '', $str);
		}
		else
		{
			// Strip unwanted characters
			$str = preg_replace("#[^a-z0-9]#i", $sep, $str);
		}

		$str = preg_replace("#[/_|+ -]+#u", $sep, $str);
		$str = trim($str, $sep);

		if ($lowercase === true)
		{
			$str = $this->str->lower($str);
		}

		return $str;
	}

	/**
	 * Turns an underscore or dash separated word and turns it into a human looking string.
	 *
	 * @param   string  the word
	 * @param   string  the separator (either _ or -)
	 * @param   bool    lowercare string and upper case first
	 * @return  string  the human version of given string
	 */
	public function humanize($str, $sep = '_', $lowercase = true)
	{
		// Allow dash, otherwise default to underscore
		$sep = $sep != '-' ? '_' : $sep;

		if ($lowercase === true)
		{
			$str = $this->str->ucfirst($str);
		}

		return str_replace($sep, " ", strval($str));
	}

	/**
	 * Takes the class name out of a modulized string.
	 *
	 * @param   string  the modulized class
	 * @return  string  the string without the class name
	 */
	public function demodulize($class_name_in_module)
	{
		return preg_replace('/^.*::/', '', strval($class_name_in_module));
	}

	/**
	 * Takes the namespace off the given class name.
	 *
	 * @param   string  the class name
	 * @return  string  the string without the namespace
	 */
	public function denamespace($class_name)
	{
		$class_name = trim($class_name, '\\');
		if ($last_separator = strrpos($class_name, '\\'))
		{
			$class_name = substr($class_name, $last_separator + 1);
		}
		return $class_name;
	}

	/**
	 * Returns the namespace of the given class name.
	 *
	 * @param   string  $class_name  the class name
	 * @return  string  the string without the namespace
	 */
	public function getNamespace($class_name)
	{
		$class_name = trim($class_name, '\\');
		if ($last_separator = strrpos($class_name, '\\'))
		{
			return substr($class_name, 0, $last_separator + 1);
		}
		return '';
	}

	/**
	 * Takes a class name and determines the table name.  The table name is a
	 * pluralized version of the class name.
	 *
	 * @param   string  the table name
	 * @return  string  the table name
	 */
	public function tableize($class_name)
	{
		$class_name = $this->denamespace($class_name);
		if (strncasecmp($class_name, 'Model_', 6) === 0)
		{
			$class_name = substr($class_name, 6);
		}
		return $this->str->lower($this->pluralize($this->underscore($class_name)));
	}

	/**
	 * Takes an underscored classname and uppercases all letters after the underscores.
	 *
	 * @param   string  classname
	 * @param   string  separator
	 * @return  string
	 */
	public function wordsToUpper($class, $sep = '_')
	{
		return str_replace(' ', $sep, ucwords(str_replace($sep, ' ', $class)));
	}

	/**
	 * Takes a table name and creates the class name.
	 *
	 * @param   string  the table name
	 * @param   bool    whether to singularize the table name or not
	 * @return  string  the class name
	 */
	public function classify($name, $force_singular = true)
	{
		$class = ($force_singular) ? $this->singularize($name) : $name;
		return $this->wordsToUpper($class);
	}

	/**
	 * Gets the foreign key for a given class.
	 *
	 * @param   string  the class name
	 * @param   bool    $use_underscore	whether to use an underscore or not
	 * @return  string  the foreign key
	 */
	public function foreignKey($class_name, $use_underscore = true)
	{
		$class_name = $this->denamespace($this->str->lower($class_name));
		if (strncasecmp($class_name, 'Model_', 6) === 0)
		{
			$class_name = substr($class_name, 6);
		}
		return $this->underscore($this->demodulize($class_name)).($use_underscore ? "_id" : "id");
	}

	/**
	 * Checks if the given word has a plural version.
	 *
	 * @param   string  the word to check
	 * @return  bool    if the word is countable
	 */
	public function isCountable($word)
	{
		return ! (\in_array($this->str->lower(\strval($word)), $this->uncountableWords));
	}
}
