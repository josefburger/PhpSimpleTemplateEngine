<?php
/**
 * Template engine - generates whole HTML of given template and parameters
 *   - key format: {{parameter-name}}
 *   - key definition: string of minimal 3 and maximal 50 characters (possible chars: a-zA-Z0-9._-)
 *
 * @author Josef Burger
 * @license MIT, GPL
 * @version 1.0.0
 */
class TemplateEngine {
    private static $ENGINE_PATTERN = '/(\{\{[a-zA-Z0-9._-]{3,50}+\}\})/i';

    protected $plainTemplate;
    protected $parameters = Array();

    /**
     * Create instance, set the plain template
     * @param string $plainTemplate plain template
     */
    public function __construct($plainTemplate) {
        $this->plainTemplate = $plainTemplate;
    }

    /**
     * returns plain template
     * @return string
     */
    public function getPlainTemplate() {
        return $this->plainTemplate;
    }

    /**
     * Returns all parameters (key => value)
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Add one parameter to engine congifuration
     * @param string $key paramater key
     * @param mixed $value
     */
    public function addParameter($key, $value) {
        $this->parameters[$key] = $value;
    }

    /**
     * Add more parameters to engine configuration
     * @param array $params (key => value)
     * @param string $keyPrefix key prefix
     */
    public function addParameters($params, $keyPrefix = '') {
        foreach($params as $key => $value) {
            $this->parameters[$keyPrefix . $key] = $value;
        }
    }

    /**
     * Render final HTML from the template of given parameters
     * @return string
     */
    public function render() {
        $pieces = preg_split(self::$ENGINE_PATTERN, $this->plainTemplate, -1, PREG_SPLIT_DELIM_CAPTURE);
        $parametersKeys = $this->getParametersKeyTags();

        foreach($pieces as $index => $piece) {
            if(in_array($piece, $parametersKeys)) {
                $pieces[$index] = $this->parameters[$this->getKeyFromTag($piece)];
            }
        }

        return implode('', $pieces);
    }

    /**
     * Returns all possible template tags
     * @return array
     */
    private function getParametersKeyTags() {
        $keys = array_keys($this->parameters);
        foreach($keys as $i => $key) {
            $keys[$i] = $this->generateKeyTag($key);
        }
        return $keys;
    }

    /**
     * Generate whole template tag (e.g. {{user.name}})
     * @param string $key parameter name
     * @return string template tag name
     */
    private function generateKeyTag($key) {
        return '{{' . $key . '}}';
    }

    /**
     * Parse parameter name from whole template tag
     * @param string $tag
     * @return string
     */
    private function getKeyFromTag($tag) {
    $tag = str_replace('{{', '', $tag);
        $tag = str_replace('}}', '', $tag);
        return $tag;
    }
}
