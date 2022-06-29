<?php

namespace app\core\form;

use app\core\Model;

/**
 * @author Jonathan Walumbe <nathanwalumbe@gmail.com>
*/
abstract class BaseField
{
    public Model $model;
    public string $attribute;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }


    abstract public function  renderInput(): string;


    public function __toString()
    {
        return sprintf('
            <div class="form-group mb-3" >
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ', $this->model->getLabels($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}