<?php

namespace SAML2\XML\md;

use SAML2\Constants;
use SAML2\Utils;

/**
 * Class representing SAML 2 SSODescriptorType.
 *
 * @package SimpleSAMLphp
 */
abstract class SSODescriptorType extends RoleDescriptor
{
    /**
     * List of ArtifactResolutionService endpoints.
     *
     * Array with IndexedEndpointType objects.
     *
     * @var \SAML2\XML\md\IndexedEndpointType[]
     */
    public $ArtifactResolutionService = [];

    /**
     * List of SingleLogoutService endpoints.
     *
     * Array with EndpointType objects.
     *
     * @var \SAML2\XML\md\EndpointType[]
     */
    public $SingleLogoutService = [];

    /**
     * List of ManageNameIDService endpoints.
     *
     * Array with EndpointType objects.
     *
     * @var \SAML2\XML\md\EndpointType[]
     */
    public $ManageNameIDService = [];

    /**
     * List of supported NameID formats.
     *
     * Array of strings.
     *
     * @var string[]
     */
    public $NameIDFormat = [];

    /**
     * Initialize a SSODescriptor.
     *
     * @param string          $elementName The name of this element.
     * @param \DOMElement|null $xml         The XML element we should load.
     */
    protected function __construct($elementName, \DOMElement $xml = null)
    {
        assert(is_string($elementName));

        parent::__construct($elementName, $xml);

        if ($xml === null) {
            return;
        }

        foreach (Utils::xpQuery($xml, './saml_metadata:ArtifactResolutionService') as $ep) {
            $this->addArtifactResolutionService(new IndexedEndpointType($ep));
        }

        foreach (Utils::xpQuery($xml, './saml_metadata:SingleLogoutService') as $ep) {
            $this->addSingleLogoutService(new EndpointType($ep));
        }

        foreach (Utils::xpQuery($xml, './saml_metadata:ManageNameIDService') as $ep) {
            $this->addManageNameIDService(new EndpointType($ep));
        }

        $this->setNameIDFormat(Utils::extractStrings($xml, Constants::NS_MD, 'NameIDFormat'));
    }

    /**
     * Collect the value of the ArtifactResolutionService-property
     * @return \SAML2\XML\md\IndexedEndpointType[]
     */
    public function getArtifactResolutionService()
    {
        return $this->ArtifactResolutionService;
    }

    /**
     * Set the value of the ArtifactResolutionService-property
     * @param \SAML2\XML\md\IndexedEndpointType[] $artifactResolutionService
     */
    public function setArtifactResolutionService(array $artifactResolutionService)
    {
        $this->ArtifactResolutionService = $artifactResolutionService;
    }

    /**
     * Add the value to the ArtifactResolutionService-property
     * @param \SAML2\XML\md\IndexedEndpointType $artifactResolutionService
     */
    public function addArtifactResolutionService(IndexedEndpointType $artifactResolutionService)
    {
        assert($artifactResolutionService instanceof IndexedEndpointType);
        $this->ArtifactResolutionService[] = $artifactResolutionService;
    }

    /**
     * Collect the value of the SingleLogoutService-property
     * @return \SAML2\XML\md\EndpointType[]
     */
    public function getSingleLogoutService()
    {
        return $this->SingleLogoutService;
    }

    /**
     * Set the value of the SingleLogoutService-property
     * @param \SAML2\XML\md\EndpointType[] $singleLogoutService
     */
    public function setSingleLogoutService(array $singleLogoutService)
    {
        $this->SingleLogoutService = $singleLogoutService;
    }

    /**
     * Add the value to the SingleLogoutService-property
     * @param \SAML2\XML\md\EndpointType $singleLogoutService
     */
    public function addSingleLogoutService(EndpointType $singleLogoutService)
    {
        assert($singleLogoutService instanceof EndpointType);
        $this->SingleLogoutService[] = $singleLogoutService;
    }

    /**
     * Collect the value of the ManageNameIDService-property
     * @return \SAML2\XML\md\EndpointType[]
     */
    public function getManageNameIDService()
    {
        return $this->ManageNameIDService;
    }

    /**
     * Set the value of the ManageNameIDService-property
     * @param \SAML2\XML\md\EndpointType[] $manageNameIDService
     */
    public function setManageNameIDService(array $manageNameIDService)
    {
        $this->ManageNameIDService = $manageNameIDService;
    }

    /**
     * Add the value to the ManageNameIDService-property
     * @param \SAML2\XML\md\EndpointType $manageNameIDService
     */
    public function addManageNameIDService(EndpointType $manageNameIDService)
    {
        assert($manageNameIDService instanceof EndpointType);
        $this->ManageNameIDService[] = $manageNameIDService;
    }

    /**
     * Collect the value of the NameIDFormat-property
     * @return string[]
     */
    public function getNameIDFormat()
    {
        return $this->NameIDFormat;
    }

    /**
     * Set the value of the NameIDFormat-property
     * @param string[] $nameIDFormat
     */
    public function setNameIDFormat(array $nameIDFormat)
    {
        $this->NameIDFormat = $nameIDFormat;
    }

    /**
     * Add this SSODescriptorType to an EntityDescriptor.
     *
     * @param  \DOMElement $parent The EntityDescriptor we should append this SSODescriptorType to.
     * @return \DOMElement The generated SSODescriptor DOMElement.
     */
    protected function toXML(\DOMElement $parent)
    {
        assert(is_array($this->getArtifactResolutionService()));
        assert(is_array($this->getSingleLogoutService()));
        assert(is_array($this->getManageNameIDService()));
        assert(is_array($this->getNameIDFormat()));

        $e = parent::toXML($parent);

        foreach ($this->getArtifactResolutionService() as $ep) {
            $ep->toXML($e, 'md:ArtifactResolutionService');
        }

        foreach ($this->getSingleLogoutService() as $ep) {
            $ep->toXML($e, 'md:SingleLogoutService');
        }

        foreach ($this->getManageNameIDService() as $ep) {
            $ep->toXML($e, 'md:ManageNameIDService');
        }

        Utils::addStrings($e, Constants::NS_MD, 'md:NameIDFormat', false, $this->getNameIDFormat());

        return $e;
    }
}
