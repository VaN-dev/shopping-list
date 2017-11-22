<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Tag;
use Comur\ImageBundle\Form\Type\CroppableImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class RecipeType
 * @package AppBundle\Form\Type
 */
class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getForm()->getData();

        $builder
            ->add('name', TextType::class)
//            ->add('people', TextType::class)
//            ->add('scope', EntityType::class, [
//                'class' => 'AppBundle\Entity\Scope',
//                'choice_label' => 'name',
//            ])
//            ->add('ingredients', CollectionType::class, [
//                'entry_type' => RecipeIngredientType::class,
//                'allow_add' => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'label' => false,
//            ])
//            ->add('tags', CollectionType::class, array(
//                'entry_type' => TagType::class,
//                'entry_options' => array('label' => false),
//                'allow_add' => true,
//                'by_reference' => false,
//                'allow_delete' => true,
//            ))
//            ->add('tags', Select2EntityType::class, [
//                'remote_route' => 'app.tag.json_list',
//                'class' => Tag::class,
//                'text_property' => 'name',
//                'multiple' => true,
//                'allow_add' => [
//                    'enabled' => true,
//                    'new_tag_text' => ' (NEW)',
//                    'new_tag_prefix' => '__',
//                    'tag_separators' => '[",", " "]'
//                ],
//            ])
//            ->add('image', CroppableImageType::class, array(
//                'uploadConfig' => array(
//                    'uploadRoute' => 'comur_api_upload',        //optional
//                    'uploadUrl' => $entity->getUploadRootDir(),       // required - see explanation below (you can also put just a dir path)
//                    'webDir' => $entity->getUploadDir(),              // required - see explanation below (you can also put just a dir path)
//                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    //optional
//                    'libraryDir' => null,                       //optional
//                    'libraryRoute' => 'comur_api_image_library', //optional
//                    'showLibrary' => true,                      //optional
////                    'saveOriginal' => 'originalImage',          //optional
//                    'generateFilename' => true          //optional
//                ),
//                'cropConfig' => array(
//                    'minWidth' => 400,
//                    'minHeight' => 300,
//                    'aspectRatio' => true,              //optional
//                    'cropRoute' => 'comur_api_crop',    //optional
//                    'forceResize' => false,             //optional
//                    'thumbs' => array(                  //optional
//                        array(
//                            'maxWidth' => 200,
//                            'maxHeight' => 150,
//                            'useAsFieldImage' => true  //optional
//                        )
//                    )
//                ),
//                'required' => false,
//            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Recipe::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vanrecipebundle_recipetype';
    }
}
