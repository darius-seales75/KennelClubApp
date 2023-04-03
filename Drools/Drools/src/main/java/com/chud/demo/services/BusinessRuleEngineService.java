package com.chud.demo.services;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.kie.api.runtime.ExecutionResults;
import org.kie.server.api.model.ServiceResponse;
import org.kie.server.client.KieServicesConfiguration;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationContext;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.stereotype.Service;

import com.chud.demo.models.SampleModel;
import com.chud.demo.util.RuleEngineUtil;

@Service
@ComponentScan(basePackages = { "com.chud.demo.*"})
public class BusinessRuleEngineService implements IBusinessRuleEngineService {
	
	/*
	 * @Autowired private ApplicationContext applicationContext;
	 */
	@Autowired
	private RuleEngineUtil ruleEngineUtil;

	@Override
	public SampleModel executeRule(SampleModel test) throws Exception{
		// TODO Auto-generated method stub
		//System.out.println("Application strat up date is:  " + applicationContext.getStartupDate());
		//ruleEngineUtil = applicationContext.getBean(RuleEngineUtil.class);
		//ruleEngineUtil = new RuleEngineUtil();
		test = ruleEngineUtil.execute(test);
		return test; 
	}
	
}
