<?php

declare(strict_types=1);

namespace SAML2\XML\shibmd;

use SAML2\Utils;

/**
 * Class which represents the Scope element found in Shibboleth metadata.
 *
 * @link https://wiki.shibboleth.net/confluence/display/SHIB/ShibbolethMetadataProfile
 * @package SimpleSAMLphp
 */
final class Scope
{
    /**
     * The namespace used for the Scope extension element.
     */
    const NS = 'urn:mace:shibboleth:metadata:1.0';

    /**
     * The scope.
     *
     * @var string
     */
    private $scope;

    /**
     * Whether this is a regexp scope.
     *
     * @var bool
     */
    private $regexp = false;

    /**
     * Create a Scope.
     *
     * @param \DOMElement|null $xml The XML element we should load.
     */
    public function __construct(\DOMElement $xml = null)
    {
        if ($xml === null) {
            return;
        }

        $this->setScope($xml->textContent);
        $this->setIsRegexpScope(Utils::parseBoolean($xml, 'regexp', false));
    }

    /**
     * Collect the value of the scope-property
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set the value of the scope-property
     * @param string $scope
     */
    public function setScope(string $scope)
    {
        $this->scope = $scope;
    }

    /**
     * Collect the value of the regexp-property
     * @return boolean
     */
    public function isRegexpScope()
    {
        return $this->regexp;
    }

    /**
     * Set the value of the regexp-property
     * @param bool $regexp
     */
    public function setIsRegexpScope(bool $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Convert this Scope to XML.
     *
     * @param \DOMElement $parent The element we should append this Scope to.
     * @return \DOMElement
     */
    public function toXML(\DOMElement $parent)
    {
        assert(is_string($this->getScope()));
        assert(is_bool($this->isRegexpScope()) || is_null($this->isRegexpScope()));

        $doc = $parent->ownerDocument;

        $e = $doc->createElementNS(Scope::NS, 'shibmd:Scope');
        $parent->appendChild($e);

        $e->appendChild($doc->createTextNode($this->getScope()));

        if ($this->isRegexpScope() === true) {
            $e->setAttribute('regexp', 'true');
        } else {
            $e->setAttribute('regexp', 'false');
        }

        return $e;
    }
}
