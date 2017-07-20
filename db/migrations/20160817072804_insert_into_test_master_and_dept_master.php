<?php

use Phinx\Migration\AbstractMigration;

class InsertIntoTestMasterAndDeptMaster extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $deptArray = [           
            ['BIO', 'BIOCHEMISTRY'],
            ['Coag', 'COAGGULATION'],
            ['CP', 'CLINICAL PATHOLOGY'],
            ['EC', 'ECG'],
            ['HAE', 'HAEMOTOLOGY'],
            ['HP', 'HISTO PATHOLOGY'],
            ['IMMUNOLOGY', 'HARMONES'],
            ['MB', 'MICRO-BIOLOGY'],
            ['MICRO BIOLOGY', 'THROAT SWAB'],
            ['SERO', 'SEROLOGY'],
            ['USG', 'USG'],
            ['USG NECK', 'RADIOLOGY'],
            ['XRY', 'X-RAY']
        ];

        $testsArray = [
            ['BIOCHEMISTRY', 'COMPLETE BLOOD  PICTURE (CBP)', '150'],
            ['BIOCHEMISTRY', 'COMPLETE URINE EXAMINATION(CUE)', '100'],
            ['BIOCHEMISTRY', 'MANTOUX TEST', '150'],
            ['SEROLOGY', 'C - Reactive Protein (CRP)', '200'],
            ['BIOCHEMISTRY', 'LIVER FUNCTION TEST', '400'],
            ['HAEMOTOLOGY', 'Parasite F and V', '250'],
            ['HAEMOTOLOGY', 'Smear for Malarial Parasite', '100'],
            ['BIOCHEMISTRY', 'SERUM AMYLASE', '400'],
            ['HAEMOTOLOGY', 'Absolute Eosinophil Count (AEC)', '100'],
            ['HAEMOTOLOGY', 'Erythrocyte Sedimentation Rate (ESR)', '100'],
            ['BIOCHEMISTRY', 'Random Blood Sugar (RBS)', '50'],
            ['BIOCHEMISTRY', 'Blood Urea', '150'],
            ['BIOCHEMISTRY', 'Serum Creatinine', '150'],
            ['BIOCHEMISTRY', 'Serum Electrolytes', '400'],
            ['BIOCHEMISTRY', 'SERUM CALCIUM', '150'],
            ['HAEMOTOLOGY', 'Prothrombin Time (PT)', '300'],
            ['HAEMOTOLOGY', 'Activated Partial Thromboplastin Time (APTT)', '400'],
            ['BIOCHEMISTRY', 'Serum Uric Acid', '150'],
            ['BIOCHEMISTRY', 'COMPLETE STOOL EXAMINATION', '150'],
            ['SEROLOGY', 'HBsAg', '150'],
            ['SEROLOGY', 'WIDAL', '150'],
            ['BIOCHEMISTRY', 'HAEMOGLOBIN', '100'],
            ['BIOCHEMISTRY', 'PLATELET COUNT', '100'],
            ['BIOCHEMISTRY', 'BLOOD GROUP', '80'],
            ['BIOCHEMISTRY', 'URINE FOR CULTURE AND SENSITIVITY', '250'],
            ['SEROLOGY', 'DENGUE SEROLOGY', '1500'],
            ['BIOCHEMISTRY', 'BLOOD SUGAR(FBS,PLBS)', '80'],
            ['BIOCHEMISTRY', 'LIPID PROFILE', '400'],
            ['SEROLOGY', 'SERUM CHOLESTEROL', '200'],
            ['BIOCHEMISTRY', 'SERUM TRYGLYCERIDES', '150'],
            ['BIOCHEMISTRY', 'ALKALINE PHOSPHATE', '150'],
            ['BIOCHEMISTRY', 'TOTAL PROTIENS', '150'],
            ['BIOCHEMISTRY', 'HBA1C', '400'],
            ['BIOCHEMISTRY', 'SERUM POTASSIUM', '150'],
            ['BIOCHEMISTRY', 'SERUM TSH', '250'],
            ['BIOCHEMISTRY', 'RA FACTOR', '200'],
            ['BIOCHEMISTRY', 'ASO TITRE', '300'],
            ['BIOCHEMISTRY', 'HIV 1 AND 2', '350'],
            ['BIOCHEMISTRY', 'HCV', '350'],
            ['BIOCHEMISTRY', 'VDRL', '150'],
            ['BIOCHEMISTRY', 'FSH,LH,PROLACTIN', '700'],
            ['BIOCHEMISTRY', 'PROLACTIN', '300'],
            ['BIOCHEMISTRY', 'SPUTUM FOR AFB', '200'],
            ['BIOCHEMISTRY', 'COOMBS TEST(DIRECT)', '350'],
            ['BIOCHEMISTRY', 'COOMBS TEST(INDIRECT)', '350'],
            ['BIOCHEMISTRY', 'BLEEDING TIME AND CLOTTING TIME', '100'],
            ['BIOCHEMISTRY', 'PACKED CELL VOLUME(PCV)', '100'],
            ['BIOCHEMISTRY', 'ANTI NATAL PACK', '1100'],
            ['BIOCHEMISTRY', 'MASTER HEALTH CHECKUP', '2200'],
            ['BIOCHEMISTRY', 'DIABETIC CHECK UP', '1000'],
            ['X-RAY', 'X RAY EACH', '200'],
            ['BIOCHEMISTRY', 'SERUM BILIRUBIN', '150'],
            ['HAEMOTOLOGY', 'Reducing Substance', '100'],
            ['BIOCHEMISTRY', 'RFT', '1050'],
            ['HAEMOTOLOGY', 'Smear for Microfilaria', '100'],
            ['HAEMOTOLOGY', 'WBC Count', '100'],
            ['HAEMOTOLOGY', 'Peripheral Smear', '100'],
            ['BIOCHEMISTRY', 'FBS', '50'],
            ['BIOCHEMISTRY', 'PLBS', '50'],
            ['HARMONES', 'TIBC', '400'],
            ['HARMONES', 'FERRITIN', '500'],
            ['HARMONES', 'IRON ', '400'],
            ['HARMONES', 'VITAMIN D3', '1500'],
            ['MICRO-BIOLOGY', 'SPUTUM FOR AFB', '200'],
            ['HAEMOTOLOGY', 'RETI COUNT', '300'],
            ['BIOCHEMISTRY', 'STOOL FOR CULTURE AND SENSITIVITY', '250']
        ];

        foreach ($deptArray as $dept) {

            $deptUUID = $this->getUUID();
            $deptRows[] = [
                'row_id' => $deptUUID,
                'created_by' => 'ashutosh',
                'created' => date('Y-m-d H:i:s'),
                'last_upd_by' => 'ashutosh',
                'last_upd' => date('Y-m-d H:i:s'),
                'deleted' => 0,
                'name' => $dept['1'],
                'code' => $dept['0']
            ];

            foreach ($testsArray as $test) {
                if($test[0] == $dept[1]){
                    $testRows[] = [
                        'row_id' => $this->getUUID(),
                        'created_by' => 'ashutosh',
                        'created' => date('Y-m-d H:i:s'),
                        'last_upd_by' => 'ashutosh',
                        'last_upd' => date('Y-m-d H:i:s'),
                        'deleted' => 0,
                        'name' => $test['1'],
                        'department_id' => $deptUUID,
                        'default_cost' => $test['2'],
                        'lower_value' => '0',
                        'higher_value' => '0'
                    ];
                }
            }
            
        }        

        // this is a handy shortcut
        $this->insert('department_master', $deptRows);
        $this->insert('test_master', $testRows);
    }

    public function getUUID(){
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
          mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
          mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
          mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
          );
    }
}
