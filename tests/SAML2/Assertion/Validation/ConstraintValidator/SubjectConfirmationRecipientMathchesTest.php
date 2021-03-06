<?php

namespace SAML2\Assertion\Validation\ConstraintValidator;

use SAML2\Assertion\Validation\Result;
use SAML2\Configuration\Destination;

class SubjectConfirmationRecipientMathchesTest extends
    \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $subjectConfirmation;

    /**
     * @var \Mockery\MockInterface
     */
    private $subjectConfirmationData;

    public function setUp()
    {
        parent::setUp();
        $this->subjectConfirmation = new \SAML2\XML\saml\SubjectConfirmation();
        $this->subjectConfirmationData = new \SAML2\XML\saml\SubjectConfirmationData();
        $this->subjectConfirmation->setSubjectConfirmationData($this->subjectConfirmationData);
    }

    /**
     * @group assertion-validation
     * @test
     */
    public function when_the_subject_confirmation_recipient_differs_from_the_destination_the_sc_is_invalid()
    {
        $this->subjectConfirmation->getSubjectConfirmationData()->setRecipient('someDestination');

        $validator = new SubjectConfirmationRecipientMatches(
            new Destination('anotherDestination')
        );
        $result = new Result();

        $validator->validate($this->subjectConfirmation, $result);

        $this->assertFalse($result->isValid());
        $this->assertCount(1, $result->getErrors());
    }

    /**
     * @group assertion-validation
     * @test
     */
    public function when_the_subject_confirmation_recipient_equals_the_destination_the_sc_is_invalid()
    {
        $this->subjectConfirmation->getSubjectConfirmationData()->setRecipient('theSameDestination');

        $validator = new SubjectConfirmationRecipientMatches(
            new Destination('theSameDestination')
        );
        $result = new Result();

        $validator->validate($this->subjectConfirmation, $result);

        $this->assertTrue($result->isValid());
    }
}
