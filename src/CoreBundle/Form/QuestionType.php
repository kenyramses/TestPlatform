<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class)
            ->add('duration')
            ->add('question_type', ChoiceType::class, array(
                'label'     => 'Type de question',
                'choices'   => array(
                    'unique'    => "unique",
                    'mulitple'  => 'multiple',
                    'open'      => 'open'
                ),
                'required'  => true
            ))
            ->add('answers', CollectionType::class, array(
                'label' => 'Réponses',
                'entry_type'   => AnswerType::class,
                'allow_add'    => true,
                'delete_empty' => true,
                'allow_delete' => true,
                'by_reference' => false,

            ))
        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_question';
    }


}
