<?php

declare(strict_types=1);

namespace SAML2\XML;

use SAML2\DOMDocumentFactory;
use SAML2\Utils;

/**
 * Serializable class used to hold an XML element.
 *
 * @package SimpleSAMLphp
 */
final class Chunk implements \Serializable
{
    /**
     * The localName of the element.
     *
     * @var string
     */
    public $localName;

    /**
     * The namespaceURI of this element.
     *
     * @var string|null
     */
    public $namespaceURI;

    /**
     * The \DOMElement we contain.
     *
     * @var \DOMElement
     */
    public $xml;

    /**
     * Create a XMLChunk from a copy of the given \DOMElement.
     *
     * @param \DOMElement $xml The element we should copy.
     */
    public function __construct(\DOMElement $xml)
    {
        $this->setLocalName($xml->localName);
        $this->setNamespaceURI($xml->namespaceURI);

        $this->setXml(Utils::copyElement($xml));
    }

    /**
     * Append this XML element to a different XML element.
     *
     * @param  \DOMElement $parent The element we should append this element to.
     * @return \DOMElement The new element.
     */
    public function toXML(\DOMElement $parent)
    {
        return Utils::copyElement($this->xml, $parent);
    }

    /**
     * Collect the value of the localName-property
     * @return string
     */
    public function getLocalName()
    {
        return $this->localName;
    }

    /**
     * Set the value of the localName-property
     * @param string $localName
     */
    public function setLocalName(string $localName)
    {
        $this->localName = $localName;
    }

    /**
     * Collect the value of the namespaceURI-property
     * @return string|null
     */
    public function getNamespaceURI()
    {
        return $this->namespaceURI;
    }

    /**
     * Set the value of the namespaceURI-property
     * @param string|null $namespaceURI
     */
    public function setNamespaceURI(string $namespaceURI = null)
    {
        $this->namespaceURI = $namespaceURI;
    }

    /**
     * Set the value of the xml-property
     * @param \DOMelement $xml
     */
    private function setXml(\DOMElement $xml)
    {
        $this->xml = $xml;
    }

    /**
     * Serialize this XML chunk.
     *
     * @return string The serialized chunk.
     */
    public function serialize()
    {
        return serialize($this->getXml()->ownerDocument->saveXML($this->getXml()));
    }

    /**
     * Un-serialize this XML chunk.
     *
     * @param string          $serialized The serialized chunk.
     * Type hint not possible due to upstream method signature
     */
    public function unserialize($serialized)
    {
        assert(is_string($serialized));
        $doc = DOMDocumentFactory::fromString(unserialize($serialized));
        $this->setXml($doc->documentElement);
        $this->setLocalName($this->getXml()->localName);
        $this->setNamespaceURI($this->getXml()->namespaceURI);
    }
}
