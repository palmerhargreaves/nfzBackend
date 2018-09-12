<?php

namespace common\models\model;

use Yii;

/**
 * This is the model class for table "agreement_model_report".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $financial_docs_file
 * @property string $additional_file
 * @property string $agreement_comments
 * @property string $agreement_comments_file
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $decline_reason_id
 * @property string $accept_date
 * @property integer $accept_processed
 * @property string $additional_file2
 * @property string $additional_file3
 * @property string $additional_file4
 * @property string $additional_file5
 * @property string $additional_file6
 * @property string $additional_file7
 * @property string $financial_docs_file1
 * @property string $financial_docs_file2
 * @property string $financial_docs_file3
 * @property string $financial_docs_file4
 * @property string $financial_docs_file5
 * @property string $financial_docs_file6
 * @property string $financial_docs_file7
 * @property string $financial_docs_file8
 * @property string $financial_docs_file9
 * @property string $financial_docs_file10
 * @property string $additional_file_ext1
 * @property string $additional_file_ext2
 * @property string $additional_file_ext3
 * @property string $additional_file_ext4
 * @property string $additional_file_ext5
 * @property string $additional_file_ext6
 * @property string $additional_file_ext7
 * @property string $additional_file_ext8
 * @property string $additional_file_ext9
 * @property string $additional_file_ext10
 * @property string $manager_status
 * @property string $designer_status
 */
class AgreementModelReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agreement_model_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'status', 'created_at', 'updated_at', 'accept_processed', 'additional_file2', 'additional_file3', 'additional_file4', 'additional_file5', 'additional_file6', 'additional_file7', 'financial_docs_file1', 'financial_docs_file2', 'financial_docs_file3', 'financial_docs_file4', 'financial_docs_file5', 'financial_docs_file6', 'financial_docs_file7', 'financial_docs_file8', 'financial_docs_file9', 'financial_docs_file10', 'additional_file_ext1', 'additional_file_ext2', 'additional_file_ext3', 'additional_file_ext4', 'additional_file_ext5', 'additional_file_ext6', 'additional_file_ext7', 'additional_file_ext8', 'additional_file_ext9', 'additional_file_ext10'], 'required'],
            [['model_id', 'decline_reason_id', 'accept_processed'], 'integer'],
            [['agreement_comments', 'status', 'manager_status', 'designer_status'], 'string'],
            [['created_at', 'updated_at', 'accept_date'], 'safe'],
            [['financial_docs_file', 'additional_file', 'agreement_comments_file', 'additional_file2', 'additional_file3', 'additional_file4', 'additional_file5', 'additional_file6', 'additional_file7', 'financial_docs_file1', 'financial_docs_file2', 'financial_docs_file3', 'financial_docs_file4', 'financial_docs_file5', 'financial_docs_file6', 'financial_docs_file7', 'financial_docs_file8', 'financial_docs_file9', 'financial_docs_file10', 'additional_file_ext1', 'additional_file_ext2', 'additional_file_ext3', 'additional_file_ext4', 'additional_file_ext5', 'additional_file_ext6', 'additional_file_ext7', 'additional_file_ext8', 'additional_file_ext9', 'additional_file_ext10'], 'string', 'max' => 255],
            [['model_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'financial_docs_file' => 'Financial Docs File',
            'additional_file' => 'Additional File',
            'agreement_comments' => 'Agreement Comments',
            'agreement_comments_file' => 'Agreement Comments File',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'decline_reason_id' => 'Decline Reason ID',
            'accept_date' => 'Accept Date',
            'accept_processed' => 'Accept Processed',
            'additional_file2' => 'Additional File2',
            'additional_file3' => 'Additional File3',
            'additional_file4' => 'Additional File4',
            'additional_file5' => 'Additional File5',
            'additional_file6' => 'Additional File6',
            'additional_file7' => 'Additional File7',
            'financial_docs_file1' => 'Financial Docs File1',
            'financial_docs_file2' => 'Financial Docs File2',
            'financial_docs_file3' => 'Financial Docs File3',
            'financial_docs_file4' => 'Financial Docs File4',
            'financial_docs_file5' => 'Financial Docs File5',
            'financial_docs_file6' => 'Financial Docs File6',
            'financial_docs_file7' => 'Financial Docs File7',
            'financial_docs_file8' => 'Financial Docs File8',
            'financial_docs_file9' => 'Financial Docs File9',
            'financial_docs_file10' => 'Financial Docs File10',
            'additional_file_ext1' => 'Additional File Ext1',
            'additional_file_ext2' => 'Additional File Ext2',
            'additional_file_ext3' => 'Additional File Ext3',
            'additional_file_ext4' => 'Additional File Ext4',
            'additional_file_ext5' => 'Additional File Ext5',
            'additional_file_ext6' => 'Additional File Ext6',
            'additional_file_ext7' => 'Additional File Ext7',
            'additional_file_ext8' => 'Additional File Ext8',
            'additional_file_ext9' => 'Additional File Ext9',
            'additional_file_ext10' => 'Additional File Ext10',
            'manager_status' => 'Manager Status',
            'designer_status' => 'Designer Status',
        ];
    }
}
