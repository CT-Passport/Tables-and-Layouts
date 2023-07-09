<?php

/**
 * https://github.com/seagullua/NameCaseLib/blob/master/Library/NCLNameCaseRu.php
 * @license Dual licensed under the MIT or GPL Version 2 licenses.
 * @package NameCaseLib
 */
/**
 * 
 */
require_once dirname(__FILE__) . '/NCL/NCLNameCaseCore.php';

/**
 * <b>NCL NameCase Russian Language</b>
 * 
 * ������� ������� ��������� ���
 * ������� ����������� ���� �������� �� ��� ��� �������� �����
 * ������� ���������� ������� ���� � ������� ��� �������� �����
 * 
 * @author ������ ����� <bymer3@gmail.com>
 * @version 0.4.1
 * @package NameCaseLib
 */
class NCLNameCaseRu extends NCLNameCaseCore
{

    /**
     * ������ ��������� �����
     * @var string 
     */
    protected $languageBuild = '11072716';
    /**
     * ���������� ������� � �����
     * @var int
     */
    protected $CaseCount = 6;
    /**
     * ������ ������� �������� �����
     * @var string 
     */
    private $vowels = "���������";
    /**
     * ������ ��������� �������� �����
     * @var string  
     */
    private $consonant = "���������������������";
    /**
     * ��������� ����/�������, ������� �� ����������
     * @var array 
     */
    private $ovo = array('���', '���', '���', '���');
    /**
     * ��������� ����/�������, ������� �� ����������
     * @var array 
     */
    private $ih = array('��', '��', '��', '��'/*�����, �������*/);
    /**
     * ������ ��������� ����������� ��� ������� 
     * �� ������� {letter}* ��� * ����� ������ ����� ���, ��� � {exclude}
     * @var array of {letter}=>{exclude}
     */
    private $splitSecondExclude = array(
        '�' => '������������',
        '�' => '�',
        '�' => '��',
        '�' => '�',
        '�' => '��',
        '�' => '���������',
        '�' => '���������',
        '�' => '',
        '�' => '�',
        '�' => '�������������',
        '�' => '��',
        '�' => '���',
        '�' => '������',
        '�' => '���',
        '�' => '��',
        '�' => '�������',
        '�' => '�',
        '�' => '�������',
        '�' => '����',
        '�' => '���',
        '�' => '���',
        '�' => '��',
        '�' => '�',
        '�' => '�',
        '�' => '',
        '�' => '�',
        '�' => '',
        '�' => '',
        '�' => '��',
        '�' => '�',
        '�' => '',
        '�' => '',
        '�' => '��'
    );

		private $names_man=array('����', '����', '�����', '�����', '�����', '������', '������',
				'�������', '����', '�����', '�������', '������', '��������', '�����', '��������',
				'������', '����', '���-����', '��������', '������', '�����', '������', '������',
				'�������', '����', '�����', '�������', '���������', '��������', '����', '���',
				'�����', '�������', '���������', '������', '���������', '������', '����', '������',
				'�������', '�����', '�������', '�������', '��', '�����', '�����', '����'
		);

    /**
     * ������� �����, �������������� �� ����� � � -�, 
     * ���������� ��� ��, ��� ������� ��������������� �������� ����
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function manRule1()
    {
        if ($this->in($this->Last(1), '��'))
        {
            if ($this->inNames($this->workingWord, array('����')))
            {
                $this->Rule(101);
                $this->makeResultTheSame();
                return true;
            }

            if ($this->Last(2, 1) != "�")
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(102);
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(103);
                return true;
            }
        }
        return false;
    }

    /**
     * ������� �����, �������������� �� ����� ������� ���������, 
     * ���������� ��� ��, ��� ������� ��������������� �������� ����
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function manRule2()
    {
        if ($this->in($this->Last(1), $this->consonant))
        {
            if ($this->inNames($this->workingWord, "�����"))
            {
                $this->lastResult = array("�����", "�����", "�����", "�����", "������", "�����");
                $this->Rule(201);
                return true;
            }
            elseif ($this->inNames($this->workingWord, "���"))
            {
                $this->lastResult = array("���", "����", "����", "����", "�����", "����");
                $this->Rule(202);
                return true;
            }
            elseif ($this->inNames($this->workingWord, '���'))
            {
                $this->Rule(203);
                $this->makeResultTheSame();
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
                $this->Rule(204);
                return true;
            }
        }
        return false;
    }

    /**
     * ������� � ������� �����, �������������� �� -�, ����������, ��� � ����� 
     * ��������������� � ����� �� ����������
     * ������� � ������� �����, �������������� �� -�, -��, -��, -��, ���������� �� �����, 
     * �� �������� ��� ����������, ���������� ��� ��������������� � ���������������� �����������
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function manRule3()
    {
        if ($this->Last(1) == "�")
        {
						if ($this->inNames($this->workingWord, array('���', '����', '������', 'Ѹ��', '����')))
            {
                $this->Rule(301);
                $this->makeResultTheSame();
                return true;
            }
            elseif (!$this->in($this->Last(2, 1), '����'))
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(302);
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(303);
                return true;
            }
        }
        elseif ($this->Last(1) == "�")
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
            $this->Rule(303);
            return true;
        }
        return false;
    }

    /**
     * ������� �������, �������������� �� -� -�, ���������� ��� ��, 
     * ��� ������� ��������������� �������� ����
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function manRule4()
    {
        if ($this->in($this->Last(1), '��'))
        {

//����� ���� �������
            if ($this->Last(3) == '���')
            {
                $this->wordForms($this->workingWord, array('��', '��', '��', '���', '��'), 2);
                $this->Rule(400);
                return true;
            }
            elseif ($this->Last(3, 1) == '�' or $this->in($this->Last(2, 1), '��'))
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(401);
                return true;
            }
//������� -� ������� 
            elseif ($this->Last(2, 1) == '�' or $this->Last(3, 1) == '�')
            {
                $this->wordForms($this->workingWord, array('���', '���', '���', '��', '��'), 2);
                $this->Rule(402);
                return true;
            }
//��������
            elseif ($this->Last(3) == '���')
            {
                $this->wordForms($this->workingWord, array('����', '����', '����', '���', '���'), 2);
                $this->Rule(403);
                return true;
            }
            elseif (!$this->in($this->Last(2, 1), $this->vowels) or $this->Last(2, 1) == '�')
            {
                $this->wordForms($this->workingWord, array('���', '���', '���', '��', '��'), 2);
                $this->Rule(404);
                return true;
            }
            else
            {
                $this->makeResultTheSame();
                $this->Rule(405);
                return true;
            }
        }
        return false;
    }

    /**
     * ������� �������, �������������� �� -�
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function manRule5()
    {
        if ($this->Last(1) == '�')
        {
//���� ����� ����� �� ��, �� ����� ������ �
						if ($this->Last(4)=='����' || $this->Last(4)=='����')//������
            {
                $this->wordForms($this->workingWord, array('��', '��', '��', '���', '��'), 2);
                $this->Rule(501);
                return true;
            }
						if ($this->Last(2, 1) == '�' && !in_array($this->Last(3, 1), array('�')))//������
            {
                $this->wordForms($this->workingWord, array('���', '���', '���', '����', '���'), 2);
                $this->Rule(502);
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
                $this->Rule(503);
                return true;
            }
        }
        return false;
    }

    /**
     * ������� ������ �� ��������� �������� ��/��/��
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function manRule6()
    {
        if ($this->Last(1) == '�')
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
            $this->Rule(601);
            return true;
        }
//� ����� � ��������
        elseif ($this->Last(2) == '��')
        {
            $this->wordForms($this->workingWord, array('��', '��', '��', '���', '��'), 2);
            $this->Rule(604);
            return true;
        }
        elseif ($this->in($this->Last(1), '�������'))
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
            $this->Rule(602);
            return true;
        }
        elseif ($this->in($this->Last(1), $this->consonant))
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
            $this->Rule(603);
            return true;
        }
        return false;
    }

    /**
     * ������� ������ �� -� -�
     * @return bool true ���� ������� ���� ������������� � false ���� ���.  
     */
    protected function manRule7()
    {
        if ($this->Last(1) == "�")
        {
						if ($this->inNames($this->workingWord, array('��')))
						{
							$this->Rule(701);
							$this->makeResultTheSame();
							return true;
						}
//���� ������ �� �, �� ����� �, ��
            if ($this->Last(2, 1) == '�')
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
								$this->Rule(702);
                return true;
            }
            elseif ($this->in($this->Last(2, 1), '���'))
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
								$this->Rule(703);
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
								$this->Rule(704);
                return true;
            }
        }
        elseif ($this->Last(1) == "�")
        {
            $this->wordForms($this->workingWord, array('��', '��', '��', '��', '��'), 2);
						$this->Rule(705);
            return true;
        }
        return false;
    }

    /**
     * �� ���������� ������� �������
     * @return bool true ���� ������� ���� ������������� � false ���� ���.  
     */
    protected function manRule8()
    {
				if ($this->in($this->Last(3), $this->ovo) || $this->in($this->Last(2), $this->ih))
        {
						if ( $this->inNames($this->workingWord, array('�����')) ) return false;
            $this->Rule(8);
            $this->makeResultTheSame();
            return true;
        }
        return false;
    }

    /**
     * ������� � ������� �����, �������������� �� -�, ����������, 
     * ��� � ����� ��������������� � ����� �� ����������
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function womanRule1()
    {
        if ($this->Last(1) == "�" and $this->Last(2, 1) != '�')
        {
            if (!$this->in($this->Last(2, 1), '����'))
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(101);
                return true;
            }
            else
            {
//�� ����� ���������
                if ($this->Last(2, 1) == '�')
                {
                    $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                    $this->Rule(102);
                    return true;
                }
                else
                {
                    $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                    $this->Rule(103);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * ������� � ������� �����, �������������� �� -�, -��, -��, -��, ���������� �� �����, 
     * �� �������� ��� ����������, ���������� ��� ��������������� � ���������������� �����������
     * @return bool true ���� ������� ���� ������������� � false ���� ���.  
     */
    protected function womanRule2()
    {
        if ($this->Last(1) == "�")
        {
            if ($this->Last(2, 1) <> "�")
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(201);
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(202);
                return true;
            }
        }
        return false;
    }

    /**
     * ������� ������� �����, �������������� �� ������ ���������, ����������, 
     * ��� ��������������� �������� ���� ���� ����, ����
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function womanRule3()
    {
        if ($this->Last(1) == "�")
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
            $this->Rule(3);
            return true;
        }
        return false;
    }

    /**
     * ������� �������, �������������� �� -� -�, ����������,
     * ��� � ����� ��������������� � ����� �� ����������
     * @return bool true ���� ������� ���� ������������� � false ���� ���. 
     */
    protected function womanRule4()
    {

        if ($this->Last(1) == "�")
        {
            if ($this->in($this->Last(2, 1), '��'))
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(401);
                return true;
            }
            elseif ($this->in($this->Last(2, 1), '�'))
            {
                $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
                $this->Rule(402);
                return true;
            }
            else
            {
                $this->wordForms($this->workingWord, array('��', '��', '�', '��', '��'), 1);
                $this->Rule(403);
                return true;
            }
        }
        elseif ($this->Last(1) == "�")
        {
            $this->wordForms($this->workingWord, array('��', '��', '��', '��', '��'), 2);
            $this->Rule(404);
            return true;
        }
        return false;
    }

    /**
     * ������� �������� ��������� ������� ������ ��� ������� ����
     * @return boolean true - ���� ���� ������������ ������� �� ������, false - ���� ������� �� ���� ��������
     */
    protected function manFirstName()
    {
        if ($this->inNames($this->workingWord, array('�������', '�������')))
        {
            $this->wordForms($this->workingWord, array('���', '���', '���', '��', '��'), 2);
            return true;
        }
        if ($this->inNames($this->workingWord, array('�����')))
        {
            //������� ����� ����
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '��'), 1);
            return true;
        }
        return $this->RulesChain('man', array(1, 2, 3));
    }

    /**
     * ������� �������� ��������� ������� ������ ��� ������� ����
     * @return boolean true - ���� ���� ������������ ������� �� ������, false - ���� ������� �� ���� ��������
     */
    protected function womanFirstName()
    {
        return $this->RulesChain('woman', array(1, 2, 3));
    }

    /**
     * ������� �������� ��������� ������� ������ ��� ������� �������
     * @return boolean true - ���� ���� ������������ ������� �� ������, false - ���� ������� �� ���� ��������
     */
    protected function manSecondName()
    {
        return $this->RulesChain('man', array(8, 4, 5, 6, 7));
    }

    /**
     * ������� �������� ��������� ������� ������ ��� ������� �������
     * @return boolean true - ���� ���� ������������ ������� �� ������, false - ���� ������� �� ���� ��������
     */
    protected function womanSecondName()
    {
        return $this->RulesChain('woman', array(4));
    }

    /**
     * ������� �������� ������� ��������
     * @return boolean true - ���� ����� ���� ������� ��������, false - ���� �� ���������� ����� �������
     */
    protected function manFatherName()
    { 
//��������� ������������� �� ��������
        if ($this->inNames($this->workingWord, '�����'))
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
            return true;
        }
        elseif ($this->Last(2) == '��')
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'));
            return true;
        }
        return false;
    }

    /**
     * ������� �������� ������� ��������
     * @return boolean true - ���� ����� ���� ������� ��������, false - ���� �� ���������� ����� �������
     */
    protected function womanFatherName()
    {
//��������� ������������� �� ��������
        if ($this->Last(2) == '��')
        {
            $this->wordForms($this->workingWord, array('�', '�', '�', '��', '�'), 1);
            return true;
        }
        return false;
    }

    /**
     * ����������� ���� �� �������� ����
     * @param NCLNameCaseWord $word ������ ������ ����, ��� �������� ����� ���������� ���
     */
    protected function GenderByFirstName(NCLNameCaseWord $word)
    {
        $this->setWorkingWord($word->getWord());

        $man = 0; //�������
        $woman = 0; //�������
        //��������� ������ �������� �� �����
        //���� ��� ������������� �� �, �� ������ ����� �������
        if ($this->Last(1) == '�')
        {
            $man+=0.9;
        }
				if ($this->in($this->Last(2), array('��', '��', '��', '��', '��', '��', '��', '��', '��'/*�������*/, '��'/*��������*/, '��', '��')))
        {
            $man+=0.3;
        }
        if ($this->in($this->Last(1), $this->consonant))
        {
            $man+=0.01;
        }
        if ($this->Last(1) == '�')
        {
            $man+=0.02;
        }

				if ($this->in($this->Last(2), array('��', '��', '��', '��')))
        {
            $woman+=0.1;
        }

        if ($this->in($this->Last(2), array('��')))
        {
            $woman+=0.04;
        }

        if ($this->in($this->Last(2), array('��', '��')))
        {
            $man+=0.01;
        }

        if ($this->in($this->Last(3), array('���', '���', '���', '���', '���', '���'/*�������, ��������*/, '���'/*������*/)))
        {
            $man+=0.2;
        }

        if ($this->in($this->Last(3), array('���')))
        {
            $woman+=0.15;
        }

        if ($this->in($this->Last(3), array('���', '���', '���', '���', '���', '���', '���', '���')))
        {
            $woman+=0.5;
        }

        if ($this->in($this->Last(4), array('����', '����', '����', '����', '����')))
        {
            $woman+=0.5;
        }
        
				if ($this->inNames($this->workingWord, $this->names_man))
        {
            $man += 10;
        }
        
				if ($this->inNames($this->workingWord, array('�������', '��������', '��������', '������', '������', '������')))
        {
            $woman += 10;
        }

				//���������� ��� ����� ���, ������� �������
				if ($this->inNames($this->workingWord, array('�����')))
				{
						$woman += 0.05;
				}

        $word->setGender($man, $woman);
    }

    /**
     * ����������� ���� �� �������� �������
     * @param NCLNameCaseWord $word ������ ������ ����, ��� �������� ����� ���������� ���
     */
    protected function GenderBySecondName(NCLNameCaseWord $word)
    {
        $this->setWorkingWord($word->getWord());

        $man = 0; //�������
        $woman = 0; //�������

        if ($this->in($this->Last(2), array('��', '��', '��', '��', '��', '��', '��', '��')))
        {
            $man+=0.4;
        }

        if ($this->in($this->Last(3), array('���', '���', '���', '���', '���', '���')))
        {
            $woman+=0.4;
        }

        if ($this->in($this->Last(2), array('��')))
        {
            $woman+=0.4;
        }

        $word->setGender($man, $woman);
    }

    /**
     * ����������� ���� �� �������� �������
     * @param NCLNameCaseWord $word ������ ������ ����, ��� �������� ����� ���������� ���
     */
    protected function GenderByFatherName(NCLNameCaseWord $word)
    {
        $this->setWorkingWord($word->getWord());

        if ($this->Last(2) == '��')
        {
            $word->setGender(10, 0); // �������
        }
        if ($this->Last(2) == '��')
        {
            $word->setGender(0, 12); // �������
        }
    }

    /**
     * ������������� ����� ��������� ��� ���, ��� �������, ��� �������� 
     * - <b>N</b> - ���
     * - <b>S</b> - �������
     * - <b>F</b> - ��������
     * @param NCLNameCaseWord $word ������ ������ ����, ������� ���������� ����������������
     */
    protected function detectNamePart(NCLNameCaseWord $word)
    {
        $namepart = $word->getWord();
        $length = NCLStr::strlen($namepart);
        $this->setWorkingWord($namepart);

//������� �����������
        $first = 0;
        $second = 0;
        $father = 0;

//���� ��������� �� ��������
        if ($this->in($this->Last(3), array('���', '���', '���', '���')))
        {
            $father+=3;
        }

        if ($this->in($this->Last(2), array('��')))
        {
            $first+=0.5;
        }

        if ($this->in($this->Last(3), array('���'/*�������, ��������*/)))
        {
            $first+=0.5;
        }

        /**
				 * ����� �� ������� ������� �� ������������� �����
         */
        if ($this->in($this->Last(1), '������������'))
        {
					/**
					 * ������ ����������
					 */
					if ($this->inNames($namepart, array('������')))
					{
						$first += 10;
					}
					else {
            $second += 0.3;
          }
				}

        /**
         * ���������� ������ ����������� ���������
         */
        if (isset($this->splitSecondExclude[$this->Last(2, 1)]))
        {
            if (!$this->in($this->Last(1), $this->splitSecondExclude[$this->Last(2, 1)]))
            {
                $second += 0.4;
            }
        }

        /**
         * ����������� ������������ ����� ���� ��� ���� �.�.�.
         */
        if ($this->Last(1) == '�' and $this->in($this->Last(3, 1), $this->vowels))
        {
            $first += 0.5;
        }

        /**
         * �� ������ ���� � ������ �������������� �������
         */
        if ($this->in($this->Last(2, 1), '������'))
        {
            $second += 0.3;
        }

        /**
         * ����� �� ������ ����. ���������� ����� ���� ���� �� ������ ����. ��� ��������� �������
         */
        if ($this->Last(1) == '�')
        {
            /**
             * ����� ���� ������ ����� �����
             */
            if ($this->Last(3, 2) == '��')
            {
                $first += 0.7;
            }
            /**
             * ������ ����������
             */
            elseif ($this->inNames($namepart, array('������', '�����', '������')))
            {
                $first += 10;
            }
            /**
             * ���� �� �� � �� ������, ����� �������
             */
            else
            {
                $second += 0.3;
            }
        }
        /**
         * ���� ��� ��������� ���� ��������� �� ������ ����� ��� �������
         */
        elseif ($this->in($this->Last(1), $this->consonant . '�') and $this->in($this->Last(2, 1), $this->consonant . '�'))
        {
            /**
             * ����������� ��� ����� ��� ������� ������������ �� ��������� �����
             */
            if (!$this->in($this->Last(2), array('��', '��', '��', '��', '��', '��', '��', '��', '��')))
            {
                $second += 0.25;
            }
        }

        /**
         * �����, ������� ������������� �� ���
         */
        if ($this->Last(3) == '���' and $this->in($this->Last(4, 1), '���'))
        {
            $first += 0.5;
        }

//����������
        if ($this->inNames($namepart, array('���', '����', '����', '����', '�����', '������',
						'����', '�����', '���', '�����', '������', '������', '����', '�����',
						'�����'/*������� ����� ����*/,
						'�������', '��������', '��������', '������', '������', '������'/*������� �����������*/))
						|| $this->inNames($namepart, $this->names_man)
						)
        {
            $first+=10;
        }



        /**
         * ������� ������� ������������� �� -�� ����� ��� ��� ���� ������ �.�.�.
         */
        if ($this->Last(2) == '��' and $this->Last(3, 1) != '�')
        {
            $second+=0.4;
        }

        /**
         * ������� �� -�� ����� ��� ��� ���� ������ ������� + �� �.�.�.
         */
        if ($this->Last(2) == '��' and $length > 2 and !$this->in($this->Last(3, 1), '��'))
        {
            $second+=0.4;
        }

        /**
         * ������� �� -�� ����� ���� ����� �����
         */
        if ($this->Last(2) == '��')
        {
            if (!$this->inNames($namepart, array('�����', '�����')))
            {
                $second += 0.4;
            }
        }

        /**
         * ������ ������������ ���� �� -��
         */
        if ($this->Last(2) == '��')
        {
            /**
             * ������������ ����� ����� ��
             */
            if ($this->in($this->Last(3, 1), '����'))
            {
                $first += 0.3;
            }
            else
            {
                $second += 0.4;
            }
        }

        /**
         * ������ ���� � �������, ������� ������������� �� ���
         */
        if ($this->Last(3) == '���')
        {
            /**
             * ��� ������� �� �������� � ��������
             */
            if ($this->in($this->Last(7), array('�������', '�������')))
            {
                $first+=10;
            }
            /**
             * ����������
             */
            elseif ($this->inNames($namepart, array('��������', '��������', '�������', '���������', '�����', '������', '������', '���������', '������', '�������', '�����', '��������', '������', '��������', '�������', '������', '�����', '����', '����', '����')))
            {
                $first+=10;
            }
            /**
             * ����� �������
             */
            else
            {
                $second += 0.4;
            }
        }

        /**
         * ����� ���� �������
         */
        if ($this->Last(4) == '����')
        {
            $first += 0.6;
        }

        /**
         * ��������� ���������
         */
        if ($this->in($this->Last(2), array('��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��', '��')))
        {
            $second+=0.4;
        }

        if ($this->in($this->Last(3), array('���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���', '���')))
        {
            $second+=0.4;
        }

        if ($this->in($this->Last(4), array('����')))
        {
            $second+=0.4;
        }

				//���������� � ��������
				if ($this->inNames($namepart, array('��', '�������', '������'))){
					$second += 10;
				}


        $max = max(array($first, $second, $father));

        if ($first == $max)
        {
            $word->setNamePart('N');
        }
        elseif ($second == $max)
        {
            $word->setNamePart('S');
        }
        else
        {
            $word->setNamePart('F');
        }
    }

}
