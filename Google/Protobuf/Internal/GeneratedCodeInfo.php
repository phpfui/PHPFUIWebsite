<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: google/protobuf/descriptor.proto

namespace Google\Protobuf\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\GPBWire;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\InputStream;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Describes the relationship between generated code and its original source
 * file. A GeneratedCodeInfo message is associated with only one generated
 * source file, but may contain references to different source .proto files.
 *
 * Generated from protobuf message <code>google.protobuf.GeneratedCodeInfo</code>
 */
class GeneratedCodeInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * An Annotation connects some span of text in generated code to an element
     * of its generating .proto file.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.GeneratedCodeInfo.Annotation annotation = 1;</code>
     */
    private $annotation;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Protobuf\Internal\GeneratedCodeInfo\Annotation>|\Google\Protobuf\Internal\RepeatedField $annotation
     *           An Annotation connects some span of text in generated code to an element
     *           of its generating .proto file.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Protobuf\Internal\Descriptor::initOnce();
        parent::__construct($data);
    }

    /**
     * An Annotation connects some span of text in generated code to an element
     * of its generating .proto file.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.GeneratedCodeInfo.Annotation annotation = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * An Annotation connects some span of text in generated code to an element
     * of its generating .proto file.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.GeneratedCodeInfo.Annotation annotation = 1;</code>
     * @param array<\Google\Protobuf\Internal\GeneratedCodeInfo\Annotation>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAnnotation($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Protobuf\Internal\GeneratedCodeInfo\Annotation::class);
        $this->annotation = $arr;

        return $this;
    }

}

