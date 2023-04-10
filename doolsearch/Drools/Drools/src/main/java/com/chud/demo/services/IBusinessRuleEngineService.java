package com.chud.demo.services;

import org.springframework.web.bind.annotation.RequestBody;

import com.chud.demo.models.SampleModel;

public interface IBusinessRuleEngineService {
	
	public SampleModel executeRule(SampleModel sampleModel) throws Exception;
	

}
